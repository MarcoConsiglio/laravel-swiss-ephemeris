<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use MarcoConsiglio\Ephemeris\Rhythms\WaxingMoonPeriod;
use MarcoConsiglio\Ephemeris\Rhythms\WaxingMoonPeriods;
use MarcoConsiglio\Ephemeris\Tests\TestCase;

class WaxingMoonPeriodsTest extends TestCase
{
    public function test_waxing_periods()
    {
        // Arrange
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm("1.11.2021", $days = 60);
        
        // Act
        $waxing_moon_periods = $synodic_rhythm->getWaxingPeriods();

        // Assert
        $this->assertInstanceOf(WaxingMoonPeriods::class, $waxing_moon_periods, 
            "SynodicRhythm should list all waxing periods");
        $this->assertContainsOnlyInstancesOf(WaxingMoonPeriod::class, $waxing_moon_periods,
            "A WaxingMoonPeriods is a collection of WaxingMoonPeriod.");
    }
}
