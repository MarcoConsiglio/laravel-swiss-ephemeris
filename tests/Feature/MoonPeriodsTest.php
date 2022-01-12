<?php

namespace MarcoConsiglio\Ephemeris\Tests\Feature;;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPeriod;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPeriods;

/**
 * @testdox A MoonPeriods collection
 */
class MoonPeriodsTest extends TestCase
{

    /**
     * @testdox consists of MoonPeriod instances.
     */
    public function test_moon_periods_is_a_collection()
    {
        // Arrange
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm("6.10.2021", 59);

        // Act
        $moon_periods = $synodic_rhythm->getPeriods();

        // Assert
        $this->assertInstanceOf(MoonPeriods::class, $moon_periods, 
            "The SynodicRhythm can be transformed to a MoonPeriods collection.");
        $this->assertContainsOnlyInstancesOf(MoonPeriod::class, $moon_periods, 
            "A MoonPeriods collection must contains only MoonPeriod instances.");
        $failure_message = "Something is wrong in finding the expected MoonPeriod(s).";
        $this->assertTrue($moon_periods->get(0)->isWaning(), $failure_message);
        $this->assertTrue($moon_periods->get(1)->isWaxing(), $failure_message);
        $this->assertTrue($moon_periods->get(2)->isWaning(), $failure_message);
        $this->assertTrue($moon_periods->get(3)->isWaxing(), $failure_message);
    }

    /**
     * @testdox has a getter that return a specific MoonPeriod.
     */
    public function test_moon_periods_has_getter()
    {
        // Arrange
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm("1.1.2000");
        $moon_periods = $synodic_rhythm->getPeriods();

        // Act
        $period = $moon_periods->get($this->faker->numberBetween(0, $moon_periods->count() - 1));
        $null_value = $moon_periods->get($moon_periods->count());

        // Assert
        $this->assertInstanceOf(MoonPeriod::class, $period, "The MoonPeriods getter must return a MoonPeriod instance.");
        $this->assertNull($null_value, "The MoonPeriods collection getter return null if the key doesn't exist.");
    }

}
