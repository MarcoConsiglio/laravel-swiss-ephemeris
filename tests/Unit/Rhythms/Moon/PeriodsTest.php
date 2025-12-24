<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Moon;

use MarcoConsiglio\Ephemeris\Enums\Moon\Period as PeriodType;
use MarcoConsiglio\Ephemeris\Records\Moon\Period;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\Periods\FromSynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Periods;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\RhythmTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;

#[TestDox("The Moon Periods collection")]
#[CoversClass(Periods::class)]
#[UsesClass(Period::class)]
#[UsesClass(PeriodType::class)]
#[UsesClass(FromSynodicRhythm::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
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
            new Period($date, $date, PeriodType::Waxing),
            new Period($date, $date, PeriodType::Waning)
        ]);

        // Act
        $periods = new Periods($periods_builder);

        // Assert
        $this->assertContainsOnlyInstancesOf(Period::class, $periods);
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
        $this->assertInstanceOf(Period::class, $first_period, 
            $this->methodMustReturn(Periods::class, "first", Period::class)
        );
        $this->assertInstanceOf(Period::class, $last_period, 
            $this->methodMustReturn(Periods::class, "last", Period::class)
        );
        $this->assertInstanceOf(Period::class, $a_period, 
            $this->methodMustReturn(Periods::class, "get", Period::class)
        );
    }
}
