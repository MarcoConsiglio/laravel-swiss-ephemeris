<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Records\Moon;

use Dom\Text;
use RoundingMode;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Enums\Moon\Period;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithCustomAssertions;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;
use Illuminate\Support\Carbon;

#[TestDox("The Moon\SynodicRhythmRecord")]
#[CoversClass(SynodicRhythmRecord::class)]
class SynodicRhythmRecordTest extends TestCase
{
    use WithCustomAssertions;

    #[TestDox("has read-only properties \"timestamp\" which is a SwissEphemerisDateTime.")]
    public function test_timestamp_property()
    {
        // Arrange
        $timestamp = $this->getTestingTimestamp(2000);
        $angular_distance = $this->getRandomAngularDistance();
        $daily_speed = $this->getRandomDailySpeed();
        $record = new SynodicRhythmRecord($timestamp, $angular_distance, $daily_speed);

        // Act & Assert
        $this->assertProperty("timestamp", $timestamp, SwissEphemerisDateTime::class, $record->timestamp);
    }

    #[TestDox("has read-only properties 'angular_distance' which is an Angle.")]
    public function test_angular_distance_property()
    {
        // Arrange
        $timestamp = $this->getTestingTimestamp(2000);
        $angular_distance = $this->getRandomAngularDistance();
        $daily_speed = $this->getRandomDailySpeed();
        $record = new SynodicRhythmRecord($timestamp, $angular_distance, $daily_speed);

        // Act & Assert
        $this->assertProperty("timestamp", $angular_distance, AngleInterface::class, $record->angular_distance);
    }

    #[TestDox("has read-only properties 'percentage' which is an integer.")]
    public function test_percentage_property()
    {
        // Arrange
        $timestamp = $this->getTestingTimestamp(2000);
        $angular_distance = $this->getRandomAngularDistance();
        $expected_percentage = round($angular_distance->toDecimal() / 180 * 100, 0, RoundingMode::HalfTowardsZero);
        $daily_speed = $this->getRandomDailySpeed();
        $record = new SynodicRhythmRecord($timestamp, $angular_distance, $daily_speed);

        // Act & Assert
        $this->assertProperty("percentage", $expected_percentage, 'integer', $record->percentage);
    }

    #[TestDox("had read-only properties 'daily_speed' which is a float.")]
    public function test_daily_speed_property()
    {
        // Arrange
        $timestamp = $this->getTestingTimestamp(2000);
        $angular_distance = $this->getRandomAngularDistance();
        $daily_speed = $this->getRandomDailySpeed();
        $record = new SynodicRhythmRecord($timestamp, $angular_distance, $daily_speed);

        // Act & Assert
        $this->assertProperty("daily_speed", $daily_speed, "float", $record->daily_speed);
    }

    #[TestDox("may belong to a waxing moon period.")]
    public function test_is_waxing()
    {
        // Arrange
        $timestamp = $this->getTestingTimestamp(2000);
        $angular_distance = $this->getRandomAngularDistance(0, 180);
        $daily_speed = $this->getRandomDailySpeed();
        $synodic_rhythm_record = new SynodicRhythmRecord($timestamp, $angular_distance, $daily_speed);

        // Act
        $is_waxing = $synodic_rhythm_record->isWaxing();
        $is_waning = $synodic_rhythm_record->isWaning();

        // Assert
        $failure_message = "Expected a waxing moon.";
        $this->assertTrue($is_waxing, $failure_message);
        $this->assertFalse($is_waning, $failure_message);
    }

    #[TestDox("may belong to a waning moon period.")]
    public function test_is_waning()
    {
        // Arrange
        $timestamp = $this->getTestingTimestamp(2000);
        $angular_distance = $this->getRandomAngularDistance(-180, 0);
        $daily_speed = $this->getRandomDailySpeed();
        $synodic_rhythm_record = new SynodicRhythmRecord($timestamp, $angular_distance, $daily_speed);

        // Act
        $is_waning = $synodic_rhythm_record->isWaning();
        $is_waxing = $synodic_rhythm_record->isWaxing();

        // Assert
        $failure_message = "Expected a waning moon.";
        $this->assertTrue($is_waning, $failure_message);
        $this->assertFalse($is_waxing, $failure_message);
    }

    #[TestDox("can establish equality with another record of the same type.")]
    public function test_is_equal()
    {
        // Arrange
        $d1 = $this->getTestingTimestamp(2000);
        $d2 = clone $d1;
        $d2->hour = 2;
        $a1 = Angle::createFromDecimal(180.0);
        $a2 = Angle::createFromDecimal(90.0);
        $daily_speed = $this->getRandomDailySpeed();
        $record_A1 = new SynodicRhythmRecord($d1, $a1, $daily_speed);
        $record_A2 = new SynodicRhythmRecord($d1, $a1, $daily_speed);
        $record_B1 = new SynodicRhythmRecord($d1, $a1, $daily_speed);
        $record_B2 = new SynodicRhythmRecord($d2, $a2, $daily_speed);
        $record_C1 = new SynodicRhythmRecord($d1, $a1, $daily_speed);
        $record_C2 = new SynodicRhythmRecord($d2, $a1, $daily_speed);
        $record_D1 = new SynodicRhythmRecord($d1, $a1, $daily_speed);
        $record_D2 = new SynodicRhythmRecord($d1, $a2, $daily_speed);

        // Act & Assert
        //      0 means not equal, 1 means equal, $daily_speed
        //      A = 1   B = 1
        $this->assertObjectEquals($record_A1, $record_A2);
        //      A = 0   B = 0
        $this->assertObjectNotEquals($record_B1, $record_B2);
        //      A = 0   B = 1
        $this->assertObjectNotEquals($record_C1, $record_C2);
        //      A = 1   B = 0
        $this->assertObjectNotEquals($record_D1, $record_D2);
    }

    #[TestDox("can determine which moon period it belongs to.")]
    public function test_moon_period_type()
    {
        // Arrange
        $record_A = new SynodicRhythmRecord(
            $this->getTestingTimestamp(2000), 
            $this->getRandomAngularDistance(-180, 0),
            $this->getRandomDailySpeed()
        );
        $record_B = new SynodicRhythmRecord(
            $this->getTestingTimestamp(2000),
            $this->getRandomAngularDistance(0, 180),
            $this->getRandomDailySpeed()
        );

        // Act
        $actual_period_type_A = $record_A->getPeriodType();
        $actual_period_type_B = $record_B->getPeriodType();

        // Assert
        $this->assertEquals(Period::Waning, $actual_period_type_A);
        $this->assertEquals(Period::Waxing, $actual_period_type_B);
    }

    #[TestDox("can be casted to string.")]
    public function test_casting_to_string()
    {
        // Arrange
        $timestamp = Carbon::create(2000, 12, 6, 3, 25, 11);
        $angular_distance = $this->getRandomAngularDistance();
        $daily_speed = $this->getRandomDailySpeed();
        $percentage = round($angular_distance->toDecimal() / 180 * 100, 0, RoundingMode::HalfTowardsZero);
        $record = new SynodicRhythmRecord(
            SwissEphemerisDateTime::createFromCarbon($timestamp),
            $angular_distance,
            $daily_speed
        );
        $period = ((array) $record->getPeriodType())["name"];
        $angular_distance = $angular_distance->toDecimal();
        $timestamp = $timestamp->toDateTimeString();

        // Act & Assert
        $this->assertEquals(<<<TEXT
Moon SynodicRhythmRecord
timestamp: $timestamp
angular_distance: {$angular_distance}°
phase_percentage: $percentage%
period_type: $period
daily_speed: {$daily_speed}°/day
TEXT,
            (string) $record
        );
    }

    protected function getTestingTimestamp($year = 0, $month = 1, $day = 1, $hour = 0, $minute = 0, $second = 0, $timezone = null): SwissEphemerisDateTime
    {
        return SwissEphemerisDateTime::create($year, $month, $day, $hour, $minute, $second, $timezone);
    }

    protected function getRandomAngularDistance(float|null $min_angular_distance = null, float|null $max_angular_distance = null): Angle
    {
        $min_angular_distance = $min_angular_distance ?? -180;
        $max_angular_distance = $max_angular_distance ?? 180;
        return Angle::createFromDecimal($this->faker->randomFloat(7, $min_angular_distance, $max_angular_distance));
    }

    protected function getRandomDailySpeed(): float
    {
        return $this->faker->randomFloat(7, 10, 14);
    }
}
