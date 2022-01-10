<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\MoonPhases;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;
use MarcoConsiglio\Ephemeris\Tests\TestCase;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\FromSynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPhaseRecord;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPhases;

/**
 * @testdox A MoonPeriods\FromSynodicRhythm builder
 */
class FromSynodicRhythmTest extends TestCase
{
    /**
     * @testdox can build a MoonPhases collection from the SynodicRhythm.
     */
    public function test_build_moon_phases_from_synodic_rhythm()
    {
        // $this->markTestSkipped("Need to refactor FromSynodicRhythm builder with strategies.");
        // Arrange
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm("4.12.2021", 31);

        // Act
        $builder = new FromSynodicRhythm($synodic_rhythm);
        $this->assertInstanceOf(Builder::class, $builder);
        $builder->validateData();
        $builder->buildRecords();
        $moon_phases = $builder->fetchCollection();

        // Assert
        $this->assertInstanceOf(MoonPhases::class, $moon_phases, "The builder must build a MoonPhases collection.");
        $this->assertContainsOnlyInstancesOf(MoonPhaseRecord::class, $moon_phases, "The collection must consists of MoonPhase enumeration values.");
    }
}