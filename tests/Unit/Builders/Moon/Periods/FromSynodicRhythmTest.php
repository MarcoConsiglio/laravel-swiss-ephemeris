<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\Moon\Periods;

use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Periods\FromSynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Period;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Tests\Unit\Builders\BuilderTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The MoonPeriods/FromSynodicRhythm builder")]
#[CoversClass(FromSynodicRhythm::class)]
class FromSynodicRhythmTest extends BuilderTestCase
{
    #[TestDox("can build a MoonPeriods collection starting from a MoonSynodicRhythm.")]
    public function test_build_moon_periods_from_synodic_rhythm()
    {
        // Arrange
        //      Mock building
        $record = SynodicRhythmRecord::class;
        $fake_date = $this->getMockedSwissEphemerisDateTime(2000)->toGregorianTT();
        $record_1 = $this->getMocked($record, ["isWaxing"], true, [$fake_date, 0.0]);
        $record_2 = $this->getMocked($record, ["isWaxing"], true, [$fake_date, 0.5]);
        $record_3 = $this->getMocked($record, ["isWaxing"], true, [$fake_date, 1.0]);
        $record_4 = $this->getMocked($record, ["isWaxing"], true, [$fake_date, -0.5]);
        $record_5 = $this->getMocked($record, ["isWaxing"], true, [$fake_date, -0.0]);
        //      Mock configuration
        $record_1->expects($this->any())->method("isWaxing")->willReturn(true);
        $record_2->expects($this->any())->method("isWaxing")->willReturn(true);
        $record_3->expects($this->any())->method("isWaxing")->willReturn(true);
        $record_4->expects($this->any())->method("isWaxing")->willReturn(false);
        $record_5->expects($this->any())->method("isWaxing")->willReturn(false);
        //      Arrange SUT
        $rhythm = new SynodicRhythm([$record_1, $record_2, $record_3, $record_4, $record_5]);
        $builder = new FromSynodicRhythm($rhythm);

        // Act
        /** @var \MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPeriods\FromSynodicRhythm $builder */
        $moon_periods = $builder->fetchCollection();

        // Assert
        $this->assertIsArray($moon_periods, 
            "The FromSynodicRhythm builder must produce a MoonPeriods collection.");
        $this->assertContainsOnlyInstancesOf(Period::class, $moon_periods, 
            "The FromSynodicRhythm builder must contains only MoonPeriod(s).");
        $this->assertGreaterThanOrEqual(1, count($moon_periods), 
            "The FromSynodicRhythm builder must return at least one MoonPeriod.");
    }

    protected function getBuilderClass(): string
    {
        return FromSynodicRhythm::class;
    }
}