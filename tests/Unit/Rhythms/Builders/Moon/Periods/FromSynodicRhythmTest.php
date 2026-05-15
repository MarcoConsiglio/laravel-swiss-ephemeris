<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Periods;

use MarcoConsiglio\Ephemeris\Enums\Moon\Period as MoonPeriod;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\Period;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromRecords;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\Periods\FromSynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Periods;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\BuilderTestCase;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Enums\Direction;
use PHPUnit\Framework\MockObject\Runtime\PropertyHook;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\MockObject\TestStubBuilder;

#[TestDox("The Moon Periods\FromSynodicRhythm builder")]
#[CoversClass(FromSynodicRhythm::class)]
#[UsesClass(FromRecords::class)]
#[UsesClass(Period::class)]
#[UsesClass(Periods::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
#[UsesClass(SynodicRhythm::class)]
class FromSynodicRhythmTest extends BuilderTestCase
{
    /**
     * Setup the test environment.
     */
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->sampling_rate = self::$faker->numberBetween(30, 1440);
    }

    #[TestDox("can build a Moon\Periods collection starting from a Moon\SynodicRhythm.")]
    public function test_build_moon_periods_from_synodic_rhythm(): void
    {
        // Arrange
        $builder_class = $this->getBuilderClass();
        $record_1 = $this->getRecordStub();
        $record_2 = $this->getRecordStub();
        $record_3 = $this->getRecordStub();
        $record_4 = $this->getRecordStub();
        $record_5 = $this->getRecordStub();
        $record_1->method("isWaxing")->willReturn(true);
        $record_1->method("getPeriodType")->willReturn(MoonPeriod::Waxing);
        $record_2->method("isWaxing")->willReturn(true);
        $record_2->method("getPeriodType")->willReturn(MoonPeriod::Waxing);
        $record_3->method("isWaxing")->willReturn(true);
        $record_3->method("getPeriodType")->willReturn(MoonPeriod::Waxing);
        $record_4->method("isWaxing")->willReturn(false);
        $record_4->method("getPeriodType")->willReturn(MoonPeriod::Waning);
        $record_5->method("isWaxing")->willReturn(false);
        $record_5->method("getPeriodType")->willReturn(MoonPeriod::Waning);

        //      Arrange SUT
        $rhythm = new SynodicRhythm(
            new FromRecords([$record_1, $record_2, $record_3, $record_4, $record_5]), 
            $this->sampling_rate
        );
        
        // Act
        $builder = new $builder_class($rhythm);
        $moon_periods = new Periods($builder);

        // Assert
        $this->assertContainsOnlyInstancesOf(Period::class, $moon_periods,
            $this->iterableMustContains(Periods::class, Period::class)
        );
    }

    /**
     * Get the current SUT class.
     */
    protected function getBuilderClass(): string
    {
        return FromSynodicRhythm::class;
    }

    protected function getRecordStub(): SynodicRhythmRecord&Stub
    {
        $stub = $this->getStubBuilder(SynodicRhythmRecord::class);
        $stub->enableOriginalConstructor();
        $stub->setConstructorArgs([
            $this->randomSwissEphemerisDateTime(), 
            $this->createStub(Angle::class), 
            $this->randomMoonDailySpeed()
        ]);
        return $stub->getStub();
    }
}