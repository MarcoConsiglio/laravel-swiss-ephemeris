<?php

namespace MarcoConsiglio\Ephemeris\Tests\Feature\Moon;

use MarcoConsiglio\Ephemeris\Rhythms\Moon\Period;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Periods;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("A Moon\Periods collection")]
#[CoversClass(Periods::class)]
class PeriodsTest extends TestCase
{
    #[TestDox("consists of Moon\Period instances.")]
    public function test_moon_periods_is_a_collection()
    {
        // Arrange in setUp()
        $period_collection = Periods::class;
        $period_class = Period::class;
        $synodic_rhythm_class = SynodicRhythm::class;
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm(new SwissEphemerisDateTime("2022-01-03"), 27);
        $failure_message = "Something is wrong in finding the expected $period_class.";

        // Act
        $moon_periods = $synodic_rhythm->getPeriods();

        // Assert
        $this->assertInstanceOf(Periods::class, $moon_periods, 
            "The $synodic_rhythm_class can be transformed to a $period_collection collection.");
        $this->assertContainsOnlyInstancesOf(Period::class, $moon_periods, 
            "A $period_collection collection must contains only $period_class instances.");
        $this->assertTrue($moon_periods->get(0)->isWaxing(), $failure_message);
        $this->assertTrue($moon_periods->get(1)->isWaning(), $failure_message);
    }

    #[TestDox("returns a specific Moon\Period.")]
    public function test_moon_periods_has_getter()
    {
        // Arrange in setUp()
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm(new SwissEphemerisDateTime("2000-01-01"), 15);
        $moon_periods = $synodic_rhythm->getPeriods();

        // Act
        $period = $moon_periods->get(fake()->numberBetween(0, $moon_periods->count() - 1));
        $null_value = $moon_periods->get($moon_periods->count());

        // Assert
        $period_collection = Periods::class;
        $period_class = Period::class;
        $this->assertInstanceOf(Period::class, $period, "The $period_collection getter must return a $period_class instance.");
        $this->assertNull($null_value, "The $period_collection getter return null if the key doesn't exist.");
    }
}
