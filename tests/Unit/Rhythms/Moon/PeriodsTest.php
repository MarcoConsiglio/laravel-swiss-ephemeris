<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Moon;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\Enums\Moon\SynodicPeriod as PeriodType;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicPeriod;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\Periods\FromSynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicPeriods;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Moon\RhythmTestCase;

#[TestDox("The Moon Periods collection")]
#[CoversClass(SynodicPeriods::class)]
class PeriodsTest extends RhythmTestCase
{
    #[TestDox("is a collection of Moon\Period instances.")]
    public function test_moon_periods_is_a_collection(): void
    {
        // Arrange
        $periods_builder = $this->getMocked(FromSynodicRhythm::class);
        $date = $this->getMockedSwissEphemerisDateTime();
        /** @var FromSynodicRhythm&MockObject $periods_builder */
        $periods_builder->expects($this->once())->method("fetchCollection")->willReturn([
            new SynodicPeriod($date, $date, PeriodType::Waxing),
            new SynodicPeriod($date, $date, PeriodType::Waning)
        ]);

        // Act
        $periods = new SynodicPeriods($periods_builder);

        // Assert
        $this->assertContainsOnlyInstancesOf(SynodicPeriod::class, $periods);
    }

    #[TestDox("can return a specific Moon\Period.")]
    public function test_getters(): void
    {
        // Arrange
        $synodic_rhythm = $this->getSynodicRhythm();
        $periods = $synodic_rhythm->getPeriods();

        // Act
        $first_period = $periods->first();
        $last_period = $periods->last();
        $a_period = $periods->get(1);

        // Assert
        $this->assertInstanceOf(SynodicPeriod::class, $first_period, 
            $this->methodMustReturn(SynodicPeriods::class, "first", SynodicPeriod::class)
        );
        $this->assertInstanceOf(SynodicPeriod::class, $last_period, 
            $this->methodMustReturn(SynodicPeriods::class, "last", SynodicPeriod::class)
        );
        $this->assertInstanceOf(SynodicPeriod::class, $a_period, 
            $this->methodMustReturn(SynodicPeriods::class, "get", SynodicPeriod::class)
        );
    }
}
