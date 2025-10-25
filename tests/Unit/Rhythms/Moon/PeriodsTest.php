<?php

namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Moon;

use MarcoConsiglio\Ephemeris\Enums\Moon\Period as PeriodType;
use MarcoConsiglio\Ephemeris\Records\Moon\Period;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Periods\FromSynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromRecords;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Periods;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The Moon\Periods")]
#[CoversClass(Periods::class)]
#[UsesClass(Period::class)]
#[UsesClass(PeriodType::class)]
class PeriodsTest extends TestCase
{
    #[TestDox("is a collection of Moon\Period instances.")]
    public function test_moon_periods_is_a_collection()
    {
        $this->markTestIncomplete();
        // Arrange
        $period_collection = Periods::class;
        $period_class = Period::class;
        $record_1 = $this->getMocked(
            SynodicRhythmRecord::class,
            original_constructor: true,
            constructor_arguments: []
        );
        $record_2 = $this->getMocked(
            SynodicRhythmRecord::class,
            original_constructor: true,
            constructor_arguments: []
        );
        $record_3 = $this->getMocked(
            SynodicRhythmRecord::class,
            original_constructor: true,
            constructor_arguments: []
        );
        $record_4 = $this->getMocked(
            SynodicRhythmRecord::class,
            original_constructor: true,
            constructor_arguments: []
        );
        $synodic_rhythm_builder = $this->getMocked(
            FromRecords::class,
            original_constructor: true,
            constructor_arguments: [$record_1, $record_2]
        );
        $synodic_rhythm = $this->getMocked(
            SynodicRhythm::class, 
            original_constructor: true,
            constructor_arguments: [$synodic_rhythm_builder]
        );
        $periods_builder = $this->getMocked(
            FromSynodicRhythm::class,
            original_constructor: true,
            constructor_arguments: [$synodic_rhythm]
        );

        // Act
        // $moon_periods = $synodic_rhythm->getPeriods();

        // Assert
    }

    #[TestDox("can return a specific Moon\Period instance.")]
    public function test_moon_periods_has_getter()
    {
        // Arrange in setUp()
        $this->markTestIncomplete();
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
