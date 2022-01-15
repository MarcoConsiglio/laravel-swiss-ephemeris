<?php

namespace MarcoConsiglio\Ephemeris\Tests\Feature;;

use App\SwissEphemeris\SwissEphemerisException;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;

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
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm(new Carbon, 1);

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
        $this->markTestSkipped("Investigate on the ephemeris datetime format and the range limits.");
        // Arrange

        // Act & Assert
        $this->expectException(SwissEphemerisException::class);
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm(new Carbon("1801-01-01"));
        $ciao = "miciomao";
    }

}
