<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Periods;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\Period;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\Periods\FromSynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromRecords;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Periods;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\BuilderTestCase;
use MarcoConsiglio\Goniometry\Angle;

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
        $this->sampling_rate = $this->faker->numberBetween(30, 1440);
    }

    #[TestDox("can build a Moon\Periods collection starting from a Moon\SynodicRhythm.")]
    public function test_build_moon_periods_from_synodic_rhythm(): void
    {
        // Arrange
        $builder_class = $this->getBuilderClass();
        $record_class = SynodicRhythmRecord::class;
        $collection_class = Periods::class;
        $items_type = Period::class;
        $daily_speed = $this->getRandomMoonDailySpeed();
        //      Mock building
        $record_1 = $this->getMocked($record_class, ["isWaxing"], true, [
            $this->getRandomSwissEphemerisDateTime(),
            $this->getSpecificAngle(0.1),
            $this->getRandomMoonDailySpeed()
        ]);
        $record_2 = $this->getMocked($record_class, ["isWaxing"], true, [
            $this->getRandomSwissEphemerisDateTime(),
            $this->getSpecificAngle(90),
            $this->getRandomMoonDailySpeed()
        ]);
        $record_3 = $this->getMocked($record_class, ["isWaxing"], true, [
            $this->getRandomSwissEphemerisDateTime(),
            $this->getSpecificAngle(179.9),
            $this->getRandomMoonDailySpeed()
        ]);
        $record_3 = $this->getMocked($record_class, ["isWaxing"], true, [
            $this->getRandomSwissEphemerisDateTime(),
            $this->getSpecificAngle(-179.9),
            $this->getRandomMoonDailySpeed()
        ]);
        $record_4 = $this->getMocked($record_class, ["isWaxing"], true, [
            $this->getRandomSwissEphemerisDateTime(),
            $this->getSpecificAngle(-90),
            $this->getRandomMoonDailySpeed()
        ]);
        $record_5 = $this->getMocked($record_class, ["isWaxing"], true, [
            $this->getRandomSwissEphemerisDateTime(),
            $this->getSpecificAngle(-0.1),
            $this->getRandomMoonDailySpeed()
        ]);
        //      Mock configuration
        $record_1->expects($this->any())->method("isWaxing")->willReturn(true);
        $record_2->expects($this->any())->method("isWaxing")->willReturn(true);
        $record_3->expects($this->any())->method("isWaxing")->willReturn(true);
        $record_4->expects($this->any())->method("isWaxing")->willReturn(false);
        $record_5->expects($this->any())->method("isWaxing")->willReturn(false);
        //      Arrange SUT
        $rhythm = new SynodicRhythm(
            new FromRecords(
                [$record_1, $record_2, $record_3, $record_4, $record_5]), 
                $this->sampling_rate
            );
        
        // Act
        $builder = new $builder_class($rhythm);
        $moon_periods = new Periods($builder);

        // Assert
        $this->assertContainsOnlyInstancesOf($items_type, $moon_periods,
            $this->iterableMustContains($collection_class, $items_type)
        );
    }

    /**
     * Get the current SUT class.
     */
    protected function getBuilderClass(): string
    {
        return FromSynodicRhythm::class;
    }
}