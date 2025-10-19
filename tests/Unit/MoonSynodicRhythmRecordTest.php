<?php

namespace MarcoConsiglio\Ephemeris\Tests\Unit;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPeriodType;
use MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithCustomAssertions;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithFailureMessage;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use RoundingMode;

#[TestDox("A MoonSynodicRhythmRecord")]
#[CoversClass(MoonSynodicRhythmRecord::class)]
class MoonSynodicRhythmRecordTest extends TestCase
{
    use WithCustomAssertions;

    #[TestDox("has read-only properties 'timestamp' which is a SwissEphemerisDateTime.")]
    public function test_timestamp_property()
    {
        // Arrange
        $timestamp = (new SwissEphemerisDateTime())->minutes(0)->seconds(0)->round();
        $angular_distance = Angle::createFromDecimal(fake()->randomFloat(1, -180, 180));

        // Act
        $record = new MoonSynodicRhythmRecord($timestamp->toGregorianUT(), $angular_distance->toDecimal());
        $actual_timestamp = $record->timestamp;

        // Assert
        $this->assertProperty("timestamp", $timestamp, SwissEphemerisDateTime::class, $actual_timestamp);
    }

    #[TestDox("has read-only properties 'angular_distance' which is an Angle.")]
    public function test_angular_distance_property()
    {
        // Arrange
        $timestamp = (new SwissEphemerisDateTime())->minutes(0)->seconds(0)->round();
        $angular_distance = Angle::createFromDecimal(fake()->randomFloat(1, -180, 180));

        // Act
        $record = new MoonSynodicRhythmRecord($timestamp->toGregorianUT(), $angular_distance->toDecimal());
        $actual_angular_distance = $record->angular_distance;

        // Assert
        $this->assertProperty("timestamp", $angular_distance, AngleInterface::class, $actual_angular_distance);
    }

    #[TestDox("has read-only properties 'percentage' which is an integer.")]
    public function test_percentage_property()
    {
        // Arrange
        $timestamp = (new SwissEphemerisDateTime())->minutes(0)->seconds(0)->round();
        $angular_distance = Angle::createFromDecimal(fake()->randomFloat(1, -180, 180));
        $raw_percentage = round($angular_distance->toDecimal() / 180, 2, RoundingMode::HalfTowardsZero);
        $expected_percentage = (int) round($raw_percentage * 100, 0, RoundingMode::HalfTowardsZero);

        // Act
        $record = new MoonSynodicRhythmRecord($timestamp->toGregorianUT(), $angular_distance->toDecimal());
        $actual_percentage = $record->percentage;

        // Assert
        $this->assertProperty("percentage", $expected_percentage, 'integer', $actual_percentage);
    }

    #[TestDox("may belong to a waxing moon period.")]
    public function test_is_waxing()
    {
        // Arrange
        $timestamp = (new SwissEphemerisDateTime)->minutes(0)->seconds(0)->toGregorianUT();
        $angular_distance = Angle::createFromDecimal(fake()->randomFloat(1, 0, 180));
        $synodic_rhythm_record = new MoonSynodicRhythmRecord(
            $timestamp,
            $angular_distance->toDecimal()
        );

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
        $timestamp = (new SwissEphemerisDateTime)->minutes(0)->seconds(0)->toGregorianUT();
        $angular_distance = Angle::createFromDecimal(fake()->randomFloat(1, -180, -0));
        $synodic_rhythm_record = new MoonSynodicRhythmRecord(
            $timestamp,
            $angular_distance->toDecimal()
        );

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
        $record_A1 = new MoonSynodicRhythmRecord(
            (new SwissEphemerisDateTime)->toGregorianTT(), 
            Angle::createFromDecimal(0.0)->toDecimal()
        ); 
        $record_A2 = $record_A1;
        $record_B = new MoonSynodicRhythmRecord(
            (new SwissEphemerisDateTime)->toGregorianTT(), 
            Angle::createFromDecimal(90)->toDecimal()
        );

        // Act & Assert
        $this->assertTrue($record_A1->equals($record_A2));
        $this->assertFalse($record_A1->equals($record_B));
    }

    #[TestDox("can determine which moon period it belongs to.")]
    public function test_moon_period_type()
    {
        // Arrange
        $record_A = new MoonSynodicRhythmRecord(
            (new SwissEphemerisDateTime)->toGregorianTT(), 
            Angle::createFromDecimal(fake()->randomFloat(1, -180, 0))->toDecimal()
        );
        $record_B = new MoonSynodicRhythmRecord(
            (new SwissEphemerisDateTime)->toGregorianTT(),
            Angle::createFromDecimal(fake()->randomFloat(1, 0, 180))->toDecimal()
        );

        // Act
        $actual_period_type_A = $record_A->getPeriodType();
        $actual_period_type_B = $record_B->getPeriodType();

        // Assert
        $this->assertEquals(MoonPeriodType::Waning, $actual_period_type_A);
        $this->assertEquals(MoonPeriodType::Waxing, $actual_period_type_B);
    }
}
