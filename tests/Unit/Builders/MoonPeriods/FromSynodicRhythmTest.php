<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\MoonPeriods;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPeriods\FromSynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPeriod;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPeriods;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Tests\Unit\Builders\BuilderTestCase;

/**
 * @testdox The MoonPeriods/FromSynodicRhythm builder
 */
class FromSynodicRhythmTest extends BuilderTestCase
{
    /**
     * @testdox can build a MoonPeriods collection starting from a SynodicRhythm.
     */
    public function test_build_moon_periods_from_synodic_rhythm()
    {
        // Arrange
        $builder = $this->getMockedRhythmBuilder(
            mocked_methods: ["buildRecords", "validateData"],
            original_constructor: true,
            constructor_arguments: [$this->getMocked(SynodicRhythm::class)]
        );
        $builder->expects($this->once())->method("buildRecords");
        $this->setObjectProperty($builder, "items", $records = [
            $this->getMocked(MoonPeriod::class),
            $this->getMocked(MoonPeriod::class),
            $this->getMocked(MoonPeriod::class)
        ]);

        // Act
        /** @var \MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPeriods\FromSynodicRhythm $builder */
        $moon_periods = $builder->fetchCollection();

        // Assert
        $this->assertIsArray($moon_periods, 
            "The FromSynodicRhythm builder must produce a MoonPeriods collection.");
        $this->assertContainsOnlyInstancesOf(MoonPeriod::class, $moon_periods, 
            "The FromSynodicRhythm builder must contains only MoonPeriod(s).");
        $this->assertGreaterThanOrEqual(1, count($moon_periods), 
            "The FromSynodicRhythm builder must return at least one MoonPeriod.");
    }

    protected function getBuilderClass(): string
    {
        return FromSynodicRhythm::class;
    }
}