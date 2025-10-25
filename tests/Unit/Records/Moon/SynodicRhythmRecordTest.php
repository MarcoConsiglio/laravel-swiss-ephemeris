<?php

namespace MarcoConsiglio\Ephemeris\Tests\Unit\Records\Moon;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Enums\Moon\Period;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithCustomAssertions;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use RoundingMode;

#[TestDox("The Moon\SynodicRhythmRecord")]
#[CoversClass(SynodicRhythmRecord::class)]
class SynodicRhythmRecordTest extends TestCase
{
    use WithCustomAssertions;

    #[TestDox("has read-only properties \"timestamp\" which is a SwissEphemerisDateTime.")]
    public function test_timestamp_property()
    {
        // Arrange
        $timestamp = (new SwissEphemerisDateTime())->minutes(0)->seconds(0)->round();
        $angular_distance = Angle::createFromDecimal(fake()->randomFloat(1, -180, 180));

        // Act
        $record = new SynodicRhythmRecord($timestamp->toGregorianUT(), $angular_distance->toDecimal());
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
        $record = new SynodicRhythmRecord($timestamp->toGregorianUT(), $angular_distance->toDecimal());
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
        $record = new SynodicRhythmRecord($timestamp->toGregorianUT(), $angular_distance->toDecimal());
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
        $synodic_rhythm_record = new SynodicRhythmRecord(
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
        $synodic_rhythm_record = new SynodicRhythmRecord(
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
        $d1 = $this->getMockedSwissEphemerisDateTime(2000);
        $d2 = clone $d1;
        $d2->hour = 2;
        $d2 = $d2->toGregorianTT();
        $d1 = $d1->toGregorianTT();
        $a1 = 180.0;
        $a2 = 90.0;
        $record_A1 = new SynodicRhythmRecord($d1, $a1);
        $record_A2 = new SynodicRhythmRecord($d1, $a1);
        $record_B1 = new SynodicRhythmRecord($d1, $a1);
        $record_B2 = new SynodicRhythmRecord($d2, $a2);
        $record_C1 = new SynodicRhythmRecord($d1, $a1);
        $record_C2 = new SynodicRhythmRecord($d2, $a1);
        $record_D1 = new SynodicRhythmRecord($d1, $a1);
        $record_D2 = new SynodicRhythmRecord($d1, $a2);

        // Act & Assert
        //      0 means not equal, 1 means equal
        //      A = 1   B = 1
        $this->assertTrue($record_A1->equals($record_A2));
        //      A = 0   B = 0
        $this->assertFalse($record_B1->equals($record_B2));
        //      A = 0   B = 1
        $this->assertFalse($record_C1->equals($record_C2));
        //      A = 1   B = 0
        $this->assertFalse($record_D1->equals($record_D2));
    }

    #[TestDox("can determine which moon period it belongs to.")]
    public function test_moon_period_type()
    {
        // Arrange
        $record_A = new SynodicRhythmRecord(
            $this->getMockedSwissEphemerisDateTime()->toGregorianTT(), 
            Angle::createFromDecimal(fake()->randomFloat(1, -180, 0))->toDecimal()
        );
        $record_B = new SynodicRhythmRecord(
            $this->getMockedSwissEphemerisDateTime()->toGregorianTT(),
            Angle::createFromDecimal(fake()->randomFloat(1, 0, 180))->toDecimal()
        );

        // Act
        $actual_period_type_A = $record_A->getPeriodType();
        $actual_period_type_B = $record_B->getPeriodType();

        // Assert
        $this->assertEquals(Period::Waning, $actual_period_type_A);
        $this->assertEquals(Period::Waxing, $actual_period_type_B);
    }
}
