<?php

namespace MarcoConsiglio\Ephemeris\Tests\Feature;;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPeriod;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPeriods;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Tests\TestCase;

/**
 * @testdox MoonPeriods collection
 */
class MoonPeriodsTest extends TestCase
{
    /**
     * @testdox consists of MoonPeriod instances.
     */
    public function test_moon_periods_is_a_collection()
    {
        // Arrange in setUp()
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm("1.1.2020", 15);

        // Act
        $moon_periods = $synodic_rhythm->getPeriods();

        // Assert
        $this->assertInstanceOf(MoonPeriods::class, $moon_periods, 
            "The SynodicRhythm can be transformed to a MoonPeriods collection.");
        $this->assertContainsOnlyInstancesOf(MoonPeriod::class, $moon_periods, 
            "A MoonPeriods collection must contains only MoonPeriod instances.");
    }

    public function test_moon_periods_is_empty_if_synodic_rhythm_is_empty()
    {
        // Arrange in setUp()
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm("1.1.2021", 1);

        // Act
        $moon_periods = $synodic_rhythm->getPeriods();

        // Assert
        $this->assertEmpty($moon_periods, "If the SynodicRhythm is empty, MoonPeriods must be empty.");
    }
}
