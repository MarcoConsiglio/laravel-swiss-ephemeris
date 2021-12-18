<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Tests\TestCase;
use MarcoConsiglio\Trigonometry\Angle;

/**
 * @testdox A Synodic Rhythm Record
 */
class SynodicRhythmRecordTest extends TestCase
{
    use WithFaker;

    /**
     * @testdox has synodic rhythm data for a timestep.
     */
    public function test_getters()
    {
        // Arrange
        $type_failure = function(string $property) {
            return "'$property' type not expected.";
        };
        $getter_failure = function($property) {
            return "'$property' property is not working properly.";
        };
        $timestamp = (new Carbon)->hours($this->faker->numberBetween(0, 24))->minutes(0)->seconds(0);
        $angular_distance = Angle::createFromDecimal($this->faker->randomFloat(1, -180, 180));
        $synodic_rhythm_record = new SynodicRhythmRecord(
            $timestamp->format("d.m.Y H:m:i")." UT",
            $angular_distance->toDecimal()
        );

        // Act
        $actual_timestamp = $synodic_rhythm_record->timestamp;
        $actual_angular_distance = $synodic_rhythm_record->angular_distance;
        $actual_percentage = $synodic_rhythm_record->percentage;

        // Assert
        $this->assertInstanceOf(Carbon::class, $actual_timestamp, $type_failure("timestamp"));
        $this->assertEquals((string) $timestamp, (string) $actual_timestamp, $getter_failure("timestamp"));
        $this->assertInstanceOf(Angle::class, $actual_angular_distance, $type_failure(Angle::class, $actual_angular_distance));
        $this->assertEquals($angular_distance->toDecimal(), $actual_angular_distance->toDecimal(), $getter_failure("angular_distance"));
        $this->assertIsFloat($actual_percentage, $type_failure("float", $actual_percentage));
    }

    /**
     * @testdox can tell if it refers to a waxing moon period.
     */
    public function test_is_waxing()
    {
        // Arrange
        $timestamp = (new Carbon)->hours($this->faker->numberBetween(0, 24))->minutes(0)->seconds(0);
        $angular_distance = Angle::createFromDecimal($this->faker->randomFloat(1, 0, 180));
        $synodic_rhythm_record = new SynodicRhythmRecord(
            $timestamp->format("d.m.Y H:m:i")." UT",
            $angular_distance->toDecimal()
        );

        // Act
        $is_waxing = $synodic_rhythm_record->isWaxing();

        // Assert
        $this->assertTrue($is_waxing, "Expected a waxing moon.");
    }

    /**
     * @testdox can tell if it refers to a waning moon period.
     */
    public function test_is_waning()
    {
        // Arrange
        $timestamp = (new Carbon)->hours($this->faker->numberBetween(0, 24))->minutes(0)->seconds(0);
        $angular_distance = Angle::createFromDecimal($this->faker->randomFloat(1, -180, -0.009));
        $synodic_rhythm_record = new SynodicRhythmRecord(
            $timestamp->format("d.m.Y H:m:i")." UT",
            $angular_distance->toDecimal()
        );

        // Act
        $is_waxing = $synodic_rhythm_record->isWaning();

        // Assert
        $this->assertTrue($is_waxing, "Expected a waning moon.");
    }
}
