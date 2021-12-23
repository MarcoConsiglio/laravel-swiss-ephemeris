<?php

namespace MarcoConsiglio\Ephemeris\Tests\Feature;;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPeriod;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPeriods;
use MarcoConsiglio\Ephemeris\Tests\TestCase;

/**
 * @testdox A MoonPeriod
 */
class MoonPeriodTest extends TestCase
{
    /**
     * @testdox has public properties.
     */
    public function test_moon_periods_is_a_collection()
    {
        // Arrange in setUp()
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm("1.1.2020", 15);

        // Act
        $moon_periods = $synodic_rhythm->getPeriods();

        // Assert
        $this->assertInstanceOf(MoonPeriods::class, $moon_periods, 
            "The SynodicRhythm must have a MoonPeriods collection.");
        $this->assertContainsOnlyInstancesOf(MoonPeriod::class, $moon_periods, 
            "A MoonPeriods collection must contains only MoonPeriod instances.");
    }
}
