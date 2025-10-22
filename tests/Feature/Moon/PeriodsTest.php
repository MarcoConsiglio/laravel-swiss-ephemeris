<?php

namespace MarcoConsiglio\Ephemeris\Tests\Feature\Moon;

use MarcoConsiglio\Ephemeris\Rhythms\Moon\Period;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Periods;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The Moon\Periods")]
#[CoversClass(Periods::class)]
class PeriodsTest extends TestCase
{
    #[TestDox("is a collection of Moon\Period instances.")]
    public function test_moon_periods_is_a_collection()
    {
        // Arrange in setUp()
        $period_collection = Periods::class;
        $period_class = Period::class;
        $synodic_rhythm_class = SynodicRhythm::class;
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm(new SwissEphemerisDateTime("2022-01-03"), 27);

        // Act
        $moon_periods = $synodic_rhythm->getPeriods();

        // Assert
        $this->assertInstanceOf(Periods::class, $moon_periods, 
            $this->methodMustReturn($synodic_rhythm_class, "getPeriods", $period_collection)
        );
        $this->assertContainsOnlyInstancesOf(Period::class, $moon_periods,
            $this->iterableMustContains($period_collection, $period_class)
        );
        $this->assertTrue($moon_periods->get(0)->isWaxing());
        $this->assertTrue($moon_periods->get(1)->isWaning());
    }

    #[TestDox("can return a specific Moon\Period instance.")]
    public function test_moon_periods_has_getter()
    {
        // Arrange in setUp()
        $period_collection = Periods::class;
        $period_class = Period::class;
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm(new SwissEphemerisDateTime("2000-01-01"), 15);
        $moon_periods = $synodic_rhythm->getPeriods();

        // Act
        $period = $moon_periods->get(fake()->numberBetween(0, $moon_periods->count() - 1));
        $null_value = $moon_periods->get($moon_periods->count());

        // Assert
        $this->assertInstanceOf($period_class, $period,
            $this->methodMustReturn($period_collection, "get", $period_class)
        );
        $this->assertNull($null_value,
            $this->methodMustReturnIf($period_collection, "get", "null", "the key doesn't exist")
        );
    }
}
