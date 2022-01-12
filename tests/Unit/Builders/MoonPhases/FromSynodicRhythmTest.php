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
use MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPhaseRecord;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPhases;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;
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
            "timestamp" => new Carbon("2021-10-06 11:00:00"),
            "angular_distance" => new Angle(new FromDecimal(-0.0614509))
        ]);
        $this->setObjectProperties($first_quarter_record, [
            "timestamp" => new Carbon("2021-10-13 03:00:00"),
            "angular_distance" => new Angle(new FromDecimal(89.7644741))
        ]);
        $this->setObjectProperties($full_moon_record, [
            "timestamp" => new Carbon("2021-10-20 15:00:00"),
            "angular_distance" => new Angle(new FromDecimal(-179.9831740))
        ]);
        $this->setObjectProperties($third_quarter_record, [
            "timestamp" => new Carbon("2021-10-28 20:00:00"),
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
            "type" => MoonPhaseType::NewMoon
        ]);
        $this->setObjectProperties($first_quarter_phase, [
            "timestamp" => new Carbon("2021-10-13 03:00:00"),
            "type" => MoonPhaseType::FirstQuarter
        ]);
        $this->setObjectProperties($full_moon_phase, [
            "timestamp" => new Carbon("2021-10-20 15:00:00"),
            "type" => MoonPhaseType::FullMoon
        ]);
        $this->setObjectProperties($third_quarter_phase, [
            "timestamp" => new Carbon("2021-10-28 20:00:00"),
            "type" => MoonPhaseType::ThirdQuarter
        ]);
        // $builder = $this->getMocked(FromSynodicRhythm::class, ["buildRecords"],
        //     original_constructor: true,
        //     constructor_arguments: [$synodic_rhythm, [NewMoon::class, FirstQuarter::class, FullMoon::class, ThirdQuarter::class]]
        // );
        // $builder->expects($this->once())->method("buildRecords");
        // $this->setObjectProperty($builder, "records", [$new_moon_phase, $first_quarter_phase, $full_moon_phase, $third_quarter_phase]);
        
        // Act
        // /** @var \MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\FromSynodicRhythm $builder */
        /** @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm $synodic_rhythm */
        $builder = new FromSynodicRhythm($synodic_rhythm, [NewMoon::class, FirstQuarter::class, FullMoon::class, ThirdQuarter::class]);
        $this->assertInstanceOf(Builder::class, $builder, // Guard Assertion
            "The FromSynodicRhythm builder must implement the rhythm Builder interface.");
        $moon_phases = $builder->fetchCollection();
        
        // Assert
        $this->assertContainsOnlyInstancesOf(MoonPhaseRecord::class, $moon_phases, 
            "The collection must contain only MoonPhaseRecord(s).");
    }

    /**
     * @testdox needs at least one MoonPhaseStrategy class.
     */
    public function test_needs_at_least_one_strategy()
    {
        // Arrange
        $synodic_rhythm = $this->getMocked(SynodicRhythm::class);
        
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The FromSynodicRhythm MoonPhases builder needs at least of one MoonPhaseStrategy class.");
        
        // Act
        /** @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm $synodic_rhythm */
        new FromSynodicRhythm($synodic_rhythm, []);
    }

    /**
     * @testdox needs only MoonPhaseStrategy classes.
     */
    public function test_needs_only_strategies()
    {
        // Arrange
        $synodic_rhythm = $this->getMocked(SynodicRhythm::class);

        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The FromSynodicRhythm MoonPhases builder needs only MoonPhaseStrategy classes.");

        // Act
        /** @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm $synodic_rhythm */
        new FromSynodicRhythm($synodic_rhythm, [Angle::class]);
    }
}