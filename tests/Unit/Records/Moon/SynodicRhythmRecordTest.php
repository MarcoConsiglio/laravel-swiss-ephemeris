<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Records\Moon;

use RoundingMode;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Enums\Moon\Period;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithRecordsComparison;

#[TestDox("The Moon SynodicRhythmRecord")]
#[CoversClass(SynodicRhythmRecord::class)]
class SynodicRhythmRecordTest extends TestCase
{
    use WithRecordsComparison;

    #[TestDox("has read-only properties \"timestamp\" which is a SwissEphemerisDateTime.")]
    public function test_timestamp_property(): void
    {
        // Arrange
        $timestamp = $this->getRandomSwissEphemerisDateTime();
        $angular_distance = $this->getRandomAngularDistance();
        $daily_speed = $this->getRandomMoonDailySpeed();
        $record = new SynodicRhythmRecord($timestamp, $angular_distance, $daily_speed);

        // Act & Assert
        $this->assertProperty("timestamp", $timestamp, SwissEphemerisDateTime::class, $record->timestamp);
    }

    #[TestDox("has read-only properties 'angular_distance' which is an Angle.")]
    public function test_angular_distance_property(): void
    {
        // Arrange
        $timestamp = $this->getMockedSwissEphemerisDateTime();
        $angular_distance = $this->getRandomAngularDistance();
        $daily_speed = $this->getRandomMoonDailySpeed();
        $record = new SynodicRhythmRecord($timestamp, $angular_distance, $daily_speed);

        // Act & Assert
        $this->assertProperty("timestamp", $angular_distance, AngleInterface::class, $record->angular_distance);
    }

    #[TestDox("has read-only properties 'percentage' which is an integer.")]
    public function test_percentage_property(): void
    {
        // Arrange
        $timestamp = $this->getMockedSwissEphemerisDateTime();
        $angular_distance = $this->getRandomAngularDistance();
        $expected_percentage = round($angular_distance->toDecimal() / 180 * 100, 0, RoundingMode::HalfTowardsZero);
        $daily_speed = $this->getRandomMoonDailySpeed();
        $record = new SynodicRhythmRecord($timestamp, $angular_distance, $daily_speed);

        // Act & Assert
        $this->assertProperty("percentage", $expected_percentage, 'integer', $record->percentage);
    }

    #[TestDox("had read-only properties 'daily_speed' which is a float.")]
    public function test_daily_speed_property(): void
    {
        // Arrange
        $timestamp = $this->getMockedSwissEphemerisDateTime();
        $angular_distance = $this->getRandomAngularDistance();
        $daily_speed = $this->getRandomMoonDailySpeed();
        $record = new SynodicRhythmRecord($timestamp, $angular_distance, $daily_speed);

        // Act & Assert
        $this->assertProperty("daily_speed", $daily_speed, "float", $record->daily_speed);
    }

    #[TestDox("may belong to a waxing moon period.")]
    public function test_is_waxing(): void
    {
        // Arrange
        $timestamp = $this->getMockedSwissEphemerisDateTime();
        $angular_distance = $this->getAngleBetween(0, 180);
        $daily_speed = $this->getRandomMoonDailySpeed();
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
    public function test_is_waning(): void
    {
        // Arrange
        $timestamp = $this->getMockedSwissEphemerisDateTime();
        $angular_distance = $this->getAngleBetween(-180, 0);
        $daily_speed = $this->getRandomMoonDailySpeed();
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
    public function test_equals_method(): void
    {
        $this->testEqualComparison(3);
    }

    #[TestDox("can determine which moon period it belongs to.")]
    public function test_moon_period_type(): void
    {
        // Arrange
        $record_A = new SynodicRhythmRecord(
            $this->getMockedSwissEphemerisDateTime(), 
            $this->getAngleBetween(-180, 0),
            $this->getRandomMoonDailySpeed()
        );
        $record_B = new SynodicRhythmRecord(
            $this->getMockedSwissEphemerisDateTime(),
            $this->getAngleBetween(0, 180),
            $this->getRandomMoonDailySpeed()
        );

        // Act
        $actual_period_type_A = $record_A->getPeriodType();
        $actual_period_type_B = $record_B->getPeriodType();

        // Assert
        $this->assertEquals(Period::Waning, $actual_period_type_A);
        $this->assertEquals(Period::Waxing, $actual_period_type_B);
    }

    #[TestDox("can be casted to string.")]
    public function test_casting_to_string(): void
    {
        // Arrange
        $timestamp = $this->getRandomSwissEphemerisDateTime();
        $angular_distance = $this->getRandomAngularDistance();
        $daily_speed = $this->getRandomMoonDailySpeed();
        $percentage = round($angular_distance->toDecimal() / 180 * 100, 0, RoundingMode::HalfTowardsZero);
        if ($percentage == -0.0) $percentage = 0;
        $record = new SynodicRhythmRecord(
            $timestamp,
            $angular_distance,
            $daily_speed
        );
        $period = ((array) $record->getPeriodType())["name"];
        $angular_distance = $angular_distance->toDecimal();
        $timestamp = $timestamp->toDateTimeString();

        // Act & Assert
        $this->assertEquals(
            <<<TEXT
SynodicRhythmRecord
angular_distance: {$angular_distance}°
daily_speed: {$daily_speed}°/day
period_type: $period
phase_percentage: $percentage%
timestamp: $timestamp

TEXT,
            (string) $record
        );
    }

    /**
     * Construct the two records to be compared with some $property_couples
     * Representsing an equal or different property.
     *
     * @param array $property_couples
     */
    protected function getComparisonDataset(): array
    {
        $d1 = $this->getRandomSwissEphemerisDateTime();
        $d2 = $d1->clone()->addYear();
        $a1 = $this->getSpecificAngle(180.0);
        $a2 = $this->getSpecificAngle(90.0);
        $s1 = 12.0;
        $s2 = 13.0;
        return [
            0 => [
                self::DIFFERENT => [$d1, $d2],
                self::EQUAL => [$d1, $d1]
            ],
            1 => [
                self::DIFFERENT => [$a1, $a2],
                self::EQUAL => [$a1, $a1]
            ],
            2 => [
                self::DIFFERENT => [$s1, $s2],
                self::EQUAL => [$s1, $s1]
            ]
        ];
    }

    /**
     * Construct the two records to be compared with some $property_couples
     * Representsing an equal or different property
     */
    protected function getRecordsToCompare(array $property_couples): array
    {
        $first = 0;
        $second = 1;
        return [
            new SynodicRhythmRecord(
                $property_couples[0][$first],
                $property_couples[1][$first],
                $property_couples[2][$first]
            ),
            new SynodicRhythmRecord(
                $property_couples[0][$second],
                $property_couples[1][$second],
                $property_couples[2][$second]
            )
        ];
    }
}
