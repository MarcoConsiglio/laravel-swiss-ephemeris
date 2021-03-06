<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\MoonPhases;

use Carbon\Carbon;
use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\FromSynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\FirstQuarter;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\FullMoon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\NewMoon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\ThirdQuarter;
use MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType as MoonPhase;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPhaseRecord;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\SwissDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Trigonometry\Angle;
use MarcoConsiglio\Trigonometry\Builders\FromDecimal;

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
        // Arrange
        $new_moon_record = $this->getMocked(SynodicRhythmRecord::class);
        $first_quarter_record = $this->getMocked(SynodicRhythmRecord::class);
        $full_moon_record = $this->getMocked(SynodicRhythmRecord::class);
        $third_quarter_record = $this->getMocked(SynodicRhythmRecord::class);
        $this->setObjectProperties($new_moon_record, [
            "timestamp" => new SwissDateTime("2021-10-06 11:00:00"),
            "angular_distance" => new Angle(new FromDecimal(-0.0614509))
        ]);
        $this->setObjectProperties($first_quarter_record, [
            "timestamp" => new SwissDateTime("2021-10-13 03:00:00"),
            "angular_distance" => new Angle(new FromDecimal(89.7644741))
        ]);
        $this->setObjectProperties($full_moon_record, [
            "timestamp" => new SwissDateTime("2021-10-20 15:00:00"),
            "angular_distance" => new Angle(new FromDecimal(-179.9831740))
        ]);
        $this->setObjectProperties($third_quarter_record, [
            "timestamp" => new SwissDateTime("2021-10-28 20:00:00"),
            "angular_distance" => new Angle(new FromDecimal(-90.0499896))
        ]);
        $synodic_rhythm = $this->getMocked(SynodicRhythm::class);
        $this->setObjectProperty($synodic_rhythm, "items", [
            $new_moon_record, $first_quarter_record, $full_moon_record, $third_quarter_record
        ]);
        $new_moon_phase = $this->getMocked(MoonPhaseRecord::class);
        $first_quarter_phase = $this->getMocked(MoonPhaseRecord::class);
        $full_moon_phase = $this->getMocked(MoonPhaseRecord::class);
        $third_quarter_phase = $this->getMocked(MoonPhaseRecord::class);
        $this->setObjectProperties($new_moon_phase, [
            "timestamp" => new Carbon("2021-10-06 11:00:00"),
            "type" => MoonPhase::NewMoon
        ]);
        $this->setObjectProperties($first_quarter_phase, [
            "timestamp" => new Carbon("2021-10-13 03:00:00"),
            "type" => MoonPhase::FirstQuarter
        ]);
        $this->setObjectProperties($full_moon_phase, [
            "timestamp" => new Carbon("2021-10-20 15:00:00"),
            "type" => MoonPhase::FullMoon
        ]);
        $this->setObjectProperties($third_quarter_phase, [
            "timestamp" => new Carbon("2021-10-28 20:00:00"),
            "type" => MoonPhase::ThirdQuarter
        ]);
        
        // Act
        /** @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm $synodic_rhythm */
        $builder = new FromSynodicRhythm($synodic_rhythm, [MoonPhase::NewMoon, MoonPhase::FirstQuarter, MoonPhase::FullMoon, MoonPhase::ThirdQuarter]);
        $this->assertInstanceOf(Builder::class, $builder, // Guard Assertion
            "The FromSynodicRhythm builder must implement the rhythm Builder interface.");
        $moon_phases = $builder->fetchCollection();
        
        // Assert
        $this->assertContainsOnlyInstancesOf(MoonPhaseRecord::class, $moon_phases, 
            "The collection must contain only MoonPhaseRecord(s).");
    }

    /**
     * @testdox needs at least one MoonPhaseType.
     */
    public function test_needs_at_least_one_moon_phase_type()
    {
        // Arrange
        $synodic_rhythm = $this->getMocked(SynodicRhythm::class);
        
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The FromSynodicRhythm MoonPhases builder needs at least a MoonPhaseType.");
        
        // Act
        /** @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm $synodic_rhythm */
        new FromSynodicRhythm($synodic_rhythm, []);
    }

    /**
     * @testdox needs only MoonPhaseType.
     */
    public function test_needs_only_moon_phase_type()
    {
        // Arrange
        $synodic_rhythm = $this->getMocked(SynodicRhythm::class);

        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Parameter 2 must be an array of MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType but found string inside.");

        // Act
        /** @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm $synodic_rhythm */
        new FromSynodicRhythm($synodic_rhythm, [Angle::class]);
    }
}