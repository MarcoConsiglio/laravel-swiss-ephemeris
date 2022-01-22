<?php
namespace MarcoConsiglio\Ephemeris\Tests\Feature;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPhaseRecord;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPhases;

/**
 * @testdox A MoonPhases collection
 */
class MoonPhasesTest extends TestCase
{
    /**
     * @testdox contains MoonPhaseRecord(s).
     */
    public function test_moon_phases()
    {
        // Arrange
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm(new Carbon("2022-01-02"), 24);

        // Act
        $moon_phases = $synodic_rhythm->getPhases([
            MoonPhaseType::NewMoon,
            MoonPhaseType::FirstQuarter,
            MoonPhaseType::FullMoon,
            MoonPhaseType::ThirdQuarter
        ]);

        // Assert
        $this->assertInstanceOf(MoonPhases::class, $moon_phases, 
            "The SynodicRhythm::getPhases method must return a MoonPhases collection.");
        $this->assertContainsOnlyInstancesOf(MoonPhaseRecord::class, $moon_phases, 
            "The MoonPhases collection must contains only MoonPhaseRecord(s).");
    }
}