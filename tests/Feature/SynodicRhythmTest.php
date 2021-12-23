<?php

namespace MarcoConsiglio\Ephemeris\Tests\Feature;;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPeriods;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Tests\TestCase as TestCase;
use MarcoConsiglio\Trigonometry\Angle;

/**
 * @testdox The SynodicRhythm
 */
class SynodicRhythmTest extends TestCase
{
    use WithFaker;

    /**
     * @testdox is a collection of SynodicRhythmRecord(s).
     */
    public function test_synodic_rhythm_records()
    {
        // Arrange in setUp()
     
        // Act
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm((new Carbon())->format("d.m.Y"), $days = 1);

        // Assert
        $this->assertInstanceOf(SynodicRhythm::class, $synodic_rhythm);
        $this->assertContainsOnlyInstancesOf(SynodicRhythmRecord::class, $synodic_rhythm, 
            "SynodicRhythm must contain SynodicRhythmRecords.");
        $this->assertEquals(24 * $days, $count = count($synodic_rhythm), 
            "The total of records must be 24 x $days = ".(24*$days).". Found $count records.");
        // $this->assertContainsOnlyInstancesOf(Carbon::class, $synodic_rhythm->pluck($timestamp_col)->all(), 
        //     "The '$timestamp_col' property must contains only Carbon instances.");
        // $this->assertContainsOnlyInstancesOf(Angle::class, $synodic_rhythm->pluck($angle_col)->all(), 
        //     "The '$angle_col' property must contains only Angle instances.");
        // $this->assertContainsOnly("float", $synodic_rhythm->pluck($percentage)->all(), 
        //     "The '$percentage' property must contains only float values.");
    }

    /**
     * @testdox throw exception if records are empty.
     */
    public function test_synodic_rhythm_throw_exception_if_records_are_empty()
    {
        // Arrange
        $empty_records = [];

        // Act & Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The SynodicRhythm must be constructed with SynodicRhythmRecord(s) or an array with 'timestamp' and 'angular_distance' setted.");
        new SynodicRhythm($empty_records);
    }

    /**
     * @testdox throw exception if records are incomplete.
     */
    public function test_synodic_rhythm_throw_exception_if_records_are_incomplete()
    {
        // Arrange
        $incomplete_records = [
            0 => [
                "timestamp" => new Carbon,
                "angular_distance" => null
            ]
        ];   
        // Act & Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The SynodicRhythm must be constructed with SynodicRhythmRecord(s) or an array with 'timestamp' and 'angular_distance' setted.");
        new SynodicRhythm($incomplete_records);
    }

    /**
     * @testdox can be converted into a MoonPeriods collection.
     */
    public function test_synodic_rhythm_has_periods()
    {
        // Arrange in setUp()
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm("4.11.2021", 30);
        
        // Act
        $moon_periods = $synodic_rhythm->getPeriods();

        // Assert
        $this->assertInstanceOf(MoonPeriods::class, $moon_periods, 
            "A SynodicRhythm should have MoonPeriods collection.");
    }
}
