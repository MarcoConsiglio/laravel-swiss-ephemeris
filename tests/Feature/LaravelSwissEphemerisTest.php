<?php

namespace Tests\Feature;

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
        // Arrange
        $angular_distance = "angular_distance";
        $timestamp = "timestamp";
        $name = "name";
        $synodic_rhythm = "percentage";

        // Act
        $response = $this->ephemeris->getMoonSynodicRhythm((new Carbon)->format("d.m.Y"), 1);

        // Assert
        $this->assertInstanceOf(SynodicRhythm::class, $response, 
            "The response should be a Collection instance, but ".gettype($response)." found.");
        $this->assertContainsOnlyInstancesOf(SynodicRhythmRecord::class, $response->all(), 
            "A SynodicRhythm must contains only SynodicRhythmRecord(s).");
    }

}
