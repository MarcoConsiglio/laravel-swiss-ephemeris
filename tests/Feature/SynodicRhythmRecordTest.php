<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Tests\TestCase;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithFailureMessage;
use MarcoConsiglio\Trigonometry\Angle;

/**
 * @testdox A Synodic Rhythm Record
 */
class SynodicRhythmRecordTest extends TestCase
{
    use WithFaker, WithFailureMessage;

    /**
     * @testdox has public properties.
     */
    public function test_getters()
    {
        // Arrange
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
        $expected_percentage = round($angular_distance->toDecimal() / 180, 2);

        // Assert
        $this->assertInstanceOf(Carbon::class, $actual_timestamp, $this->typeFail("timestamp"));
        $this->assertEquals((string) $timestamp, (string) $actual_timestamp, $this->getterFail("timestamp"));
        $this->assertInstanceOf(Angle::class, $actual_angular_distance, $this->typeFail("angular_distance"));
        $this->assertEquals($angular_distance->toDecimal(), $actual_angular_distance->toDecimal(), $this->getterFail("angular_distance"));
        $this->assertIsFloat($actual_percentage, $this->typeFail("percentage"));
        $this->assertEquals($expected_percentage, $actual_percentage, $this->getterFail("angular_distance"));
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
