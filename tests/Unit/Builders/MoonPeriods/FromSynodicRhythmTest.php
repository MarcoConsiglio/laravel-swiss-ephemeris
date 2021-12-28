<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\MoonPeriods;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPeriods\FromSynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPeriods;
use MarcoConsiglio\Ephemeris\Tests\TestCase;

/**
 * @testdox The FromSynodicRhythm builder
 */
class FromSynodicRhythmTest extends TestCase
{
    /**
     * @testdox can build a MoonPeriods collection.
     */
    public function test_build_moon_periods_from_synodic_rhythm()
    {
        // Arrange
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm("1.1.2000");

        // Act
        $builder = new FromSynodicRhythm($synodic_rhythm);
        $builder->validateData();
        $builder->buildRecords();
        $moon_periods = $builder->fetchCollection();

        // Assert
        $this->assertInstanceOf(Builder::class, $builder, "Every rhythm builder must realize the Builder interface.");
        $this->assertInstanceOf(MoonPeriods::class, $moon_periods, "The FromSynodicRhythm builder must produce a MoonPeriods collection.");
    }
}