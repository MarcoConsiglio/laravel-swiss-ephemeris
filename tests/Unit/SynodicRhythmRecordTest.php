<?php

namespace MarcoConsiglio\Ephemeris\Tests\Unit;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\SwissDateTime;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithCustomAssertions;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithFailureMessage;
use MarcoConsiglio\Trigonometry\Angle;
use MarcoConsiglio\Trigonometry\Interfaces\Angle as AngleInterface;

/**
 * @testdox A Synodic Rhythm Record
 */
class SynodicRhythmRecordTest extends TestCase
{
    use WithCustomAssertions;
    

    /**
     * @testdox has read-only properties 'timestamp', 'angular_distance' and 'percentage'.
     */
    public function test_getters()
    {
        // Arrange
        $timestamp = (new SwissDateTime)->minutes(0)->seconds(0)->round();
        $angular_distance = Angle::createFromDecimal($this->faker->randomFloat(1, -180, 180));
        
        // Act
        $synodic_rhythm_record = new SynodicRhythmRecord(
            $timestamp->toGregorianUT(),
            $angular_distance->toDecimal()
        );
        $actual_timestamp = $synodic_rhythm_record->timestamp;
        $actual_angular_distance = $synodic_rhythm_record->angular_distance;
        $actual_percentage = $synodic_rhythm_record->percentage;
        $expected_percentage = round($angular_distance->toDecimal() / 180, 2);
        $unknown_property = $synodic_rhythm_record->shabadula;

        // Assert
        $this->assertProperty("timestamp", $timestamp, SwissDateTime::class, $actual_timestamp);
        $this->assertProperty("angular_distance", $angular_distance, AngleInterface::class, $actual_angular_distance);
        $this->assertProperty("percentage", $expected_percentage, "float", $actual_percentage);
        $this->assertNull($unknown_property, "An unknown property must be null.");
    }

    /**
     * @testdox can tell if it is waxing moon period.
     */
    public function test_is_waxing()
    {
        // Arrange
        $timestamp = (new SwissDateTime)->minutes(0)->seconds(0)->toGregorianUT();
        $angular_distance = Angle::createFromDecimal($this->faker->randomFloat(1, 0, 180));
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

    /**
     * @testdox can tell if it is a waning moon period.
     */
    public function test_is_waning()
    {
        // Arrange
        $timestamp = (new SwissDateTime)->minutes(0)->seconds(0)->toGregorianUT();
        $angular_distance = Angle::createFromDecimal($this->faker->randomFloat(1, -180, -0));
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
}
