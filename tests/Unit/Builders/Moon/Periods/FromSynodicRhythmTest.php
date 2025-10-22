<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\Moon\Periods;

use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Periods\FromSynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Period;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Periods;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Tests\Unit\Builders\BuilderTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The Moon\Periods\FromSynodicRhythm builder")]
#[CoversClass(FromSynodicRhythm::class)]
class FromSynodicRhythmTest extends BuilderTestCase
{
    #[TestDox("can build a Moon\Periods collection starting from a Moon\SynodicRhythm.")]
    public function test_build_moon_periods_from_synodic_rhythm()
    {
        // Arrange
        $builder_class = FromSynodicRhythm::class;
        $record_class = SynodicRhythmRecord::class;
        $collection_class = Periods::class;
        $items_type = Period::class;
        //      Mock building
        $fake_date = $this->getMockedSwissEphemerisDateTime(2000)->toGregorianTT();
        $record_1 = $this->getMocked($record_class, ["isWaxing"], true, [$fake_date, 0.0]);
        $record_2 = $this->getMocked($record_class, ["isWaxing"], true, [$fake_date, 0.5]);
        $record_3 = $this->getMocked($record_class, ["isWaxing"], true, [$fake_date, 1.0]);
        $record_4 = $this->getMocked($record_class, ["isWaxing"], true, [$fake_date, -0.5]);
        $record_5 = $this->getMocked($record_class, ["isWaxing"], true, [$fake_date, -0.0]);
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
        /** @var FromSynodicRhythm $builder */
        $moon_periods = $builder->fetchCollection();

        // Assert
        $this->assertIsArray($moon_periods,
            $this->methodMustReturn($builder_class, "fetchCollection", $collection_class)
        );
        $this->assertContainsOnlyInstancesOf(Period::class, $moon_periods,
            $this->iterableMustContains($collection_class, $items_type)
        );
        // This assertion fail if the data set (SynodicRhythmRecord instances) is too small.
        // It is necessary to add a test to check the count is zero if the data set is too small. 
        $this->assertGreaterThanOrEqual(1, count($moon_periods));
    }

    /**
     * Gets the correct Builder class to test.
     *
     * @return string
     */
    protected function getBuilderClass(): string
    {
        return FromSynodicRhythm::class;
    }
}