<?php

namespace MarcoConsiglio\Ephemeris\Tests\Feature;;

use App\SwissEphemeris\SwissEphemerisException;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\SwissDateTime;
use ReflectionClass;

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
     * @testdox can obtain the Swiss Ephemeris header.
     */
    public function test_header()
    {
        // Arrange
        $ephemeris_class = new ReflectionClass($this->ephemeris);
        $get_header_method = $ephemeris_class->getMethod("getHeader");
        $get_header_method->setAccessible(true);
        $date = (new SwissDateTime)->roundDays();
        
        // Act
        $header = $get_header_method->invokeArgs($this->ephemeris, [$date]);

        // Assert
        $this->assertIsArray($header);
        $this->assertCount(7, $header, "The header should be 7 rows. Is it changed?");
    }

    // /**
    //  * @testdox throws the SwissEphemerisException if something went wrong.
    //  */
    // public function test_synodic_rhythm_error()
    // {
    //     // Arrange

    //     // Act & Assert
    //     $this->expectException(SwissEphemerisException::class);
    //     $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm(new Carbon("1801-01-01"));
    // }

}
