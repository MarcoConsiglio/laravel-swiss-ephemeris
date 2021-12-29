<?php

namespace MarcoConsiglio\Ephemeris\Tests\Feature;;

use App\SwissEphemeris\SwissEphemerisException;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Tests\TestCase;
use MarcoConsiglio\Ephemeris\LaravelSwissEphemeris;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;
use MarcoConsiglio\Trigonometry\Angle;

/**
 * @testdox The Laravel Swiss Ephemeris
 */
class LaravelSwissEphemerisTest extends TestCase
{
    /**
     * @testdox can show Synodic Rhythm.
     */
    public function test_synodic_rhythm()
    {
        // Arrange in setUp()

        // Act
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm((new Carbon)->format("d.m.Y"), 1);

        // Assert
        $this->assertInstanceOf(SynodicRhythm::class, $synodic_rhythm, 
            "The synodic_rhythm should be a Collection instance, but ".gettype($synodic_rhythm)." found.");
        $this->assertContainsOnlyInstancesOf(SynodicRhythmRecord::class, $synodic_rhythm, 
            "A SynodicRhythm must contains only SynodicRhythmRecord(s).");
    }

    /**
     * @testdox throws the SwissEphemerisException if something went wrong.
     */
    public function test_synodic_rhythm_error()
    {
        // Arrange

        // Act & Assert
        $this->expectException(SwissEphemerisException::class);
        $this->ephemeris->getMoonSynodicRhythm("1.1.1", -30);
    }

}
