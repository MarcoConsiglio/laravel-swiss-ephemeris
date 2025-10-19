<?php

namespace MarcoConsiglio\Ephemeris\Tests\Feature;;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPeriodType;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPeriod;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPeriods;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithFailureMessage;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("A MoonPeriods collection")]
#[CoversClass(MoonPeriods::class)]
class MoonPeriodsTest extends TestCase
{
    #[TestDox("consists of MoonPeriod instances.")]
    public function test_moon_periods_is_a_collection()
    {
        // Arrange in setUp()
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm(new SwissEphemerisDateTime("2022-01-03"), 27);
        $failure_message = "Something is wrong in finding the expected MoonPeriod(s).";

        // Act
        $moon_periods = $synodic_rhythm->getPeriods();

        // Assert
        $this->assertInstanceOf(MoonPeriods::class, $moon_periods, 
            "The MoonSynodicRhythm can be transformed to a MoonPeriods collection.");
        $this->assertContainsOnlyInstancesOf(MoonPeriod::class, $moon_periods, 
            "A MoonPeriods collection must contains only MoonPeriod instances.");
        $this->assertTrue($moon_periods->get(0)->isWaxing(), $failure_message);
        $this->assertTrue($moon_periods->get(1)->isWaning(), $failure_message);
    }

    #[TestDox("returns a specific MoonPeriod.")]
    public function test_moon_periods_has_getter()
    {
        // Arrange in setUp()
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm(new SwissEphemerisDateTime("2000-01-01"), 15);
        $moon_periods = $synodic_rhythm->getPeriods();

        // Act
        $period = $moon_periods->get(fake()->numberBetween(0, $moon_periods->count() - 1));
        $null_value = $moon_periods->get($moon_periods->count());

        // Assert
        $this->assertInstanceOf(MoonPeriod::class, $period, "The MoonPeriods getter must return a MoonPeriod instance.");
        $this->assertNull($null_value, "The MoonPeriods collection getter return null if the key doesn't exist.");
    }
}
