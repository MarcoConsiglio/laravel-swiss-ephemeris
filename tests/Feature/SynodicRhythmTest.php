<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Tests\TestCase as TestCase;
use MarcoConsiglio\Trigonometry\Angle;

/**
 * @testdox A SynodicRhythm
 */
class SynodicRhythmTest extends TestCase
{
    use WithFaker;

    /**
     * @testdox can show its data.
     */
    public function test_synodic_rhythm_can_show_data()
    {
        // Arrange in setUp()
        $timestamp_col = "timestamp";
        $angle_col = "angular_distance";
        $percentage = "percentage";
        
        // Act
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm((new Carbon())->format("d.m.Y"), $days = 1);

        // Assert
        $this->assertInstanceOf(SynodicRhythm::class, $synodic_rhythm);
        $this->assertEquals(24 * $days, count($synodic_rhythm), 
            "The record must be 24 x $days = ".(24*$days).".");
        $this->assertContainsOnlyInstancesOf(Carbon::class, $synodic_rhythm->pluck($timestamp_col)->all(), 
            "The '$timestamp_col' column must contains only Carbon instances.");
        $this->assertContainsOnlyInstancesOf(Angle::class, $synodic_rhythm->pluck($angle_col)->all(), 
            "The '$angle_col' column must contains only Angle instances.");
        $this->assertContainsOnly("float", $synodic_rhythm->pluck($percentage)->all(), 
            "The '$percentage' column must contains only float values.");
    }

    /**
     * @testdox can show waxing phase.
     */
    public function test_synodic_rhythm_can_show_waxing_phase()
    {
        // Arrange in setUp()
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm("4.12.2021", 16);
        $record = $synodic_rhythm->random();
        $key = $synodic_rhythm->search($record, true);

        // Act & Assert
        $failure_message = "The test data should be referred to a waxing moon. Is the isWaxing() method working?";
        $this->assertTrue($synodic_rhythm->isWaxing($key), $failure_message);
        $this->assertTrue($synodic_rhythm->isWaxing($record["timestamp"]), $failure_message);
        $this->assertInstanceOf(Collection::class, $synodic_rhythm->getWaxingPeriods(), 
            "A SynodicRhythm must offer a collection of WaxingMoonPeriods.");
        $this->expectException(InvalidArgumentException::class);
        $synodic_rhythm->isWaxing(true);
    }
}
