<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\Moon\Phases;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Enums\Moon\Phase;
use MarcoConsiglio\Ephemeris\Records\Moon\PhaseRecord;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Phases\FromSynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;

#[TestDox("The Moon\Phases\FromMoonSynodicRhythm builder")]
#[CoversClass(FromSynodicRhythm::class)]
class FromSynodicRhythmTest extends TestCase
{
    #[TestDox("can build a Moon\Phases collection from the Moon\SynodicRhythm.")]
    public function test_build_moon_phases_from_synodic_rhythm()
    {
        // Arrange
        $record_class = PhaseRecord::class;
        $date_1 = new SwissEphemerisDateTime("2021-10-06 11:00:00");
        $date_2 = new SwissEphemerisDateTime("2021-10-13 03:00:00");
        $date_3 = new SwissEphemerisDateTime("2021-10-20 15:00:00");
        $date_4 = new SwissEphemerisDateTime("2021-10-28 20:00:00");
        $new_moon_record = new SynodicRhythmRecord(
            $date_1->toGregorianTT(),
            -0.0614509
        );
        $first_quarter_record = new SynodicRhythmRecord(
            $date_2->toGregorianTT(),
            89.7644741
        );
        $full_moon_record = new SynodicRhythmRecord(
            $date_3->toGregorianTT(),
            -179.9831740
        );
        $third_quarter_record = new SynodicRhythmRecord(
            $date_4->toGregorianTT(),
            -90.0499896
        );
        $synodic_rhythm = new SynodicRhythm([
            $new_moon_record,
            $first_quarter_record,
            $full_moon_record,
            $third_quarter_record
        ]);

        // Act
        /** @var SynodicRhythm $synodic_rhythm */
        $builder = new FromSynodicRhythm($synodic_rhythm, Phase::cases());
        $moon_phases = $builder->fetchCollection();
        
        // Assert
        $this->assertIsArray($moon_phases,
            "The collection must be an array"
        );
        $this->assertContainsOnlyInstancesOf($record_class, $moon_phases,
            $this->iterableMustContains("array", $record_class)
        );
    }

    #[TestDox("cannot build without Moon\Phase constants.")]
    public function test_needs_at_least_one_moon_phase_type()
    {
        // Arrange
        $synodic_rhythm = $this->getMocked(SynodicRhythm::class);
        
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The FromMoonSynodicRhythm MoonPhases builder needs at least a MoonPhaseType.");
        
        // Act
        /** @var SynodicRhythm $synodic_rhythm */
        new FromSynodicRhythm($synodic_rhythm, []);
    }

    #[TestDox("can build only with Moon\Phase constants.")]
    public function test_needs_only_moon_phase_type()
    {
        // Arrange
        $synodic_rhythm = $this->getMocked(SynodicRhythm::class);

        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Parameter 2 must be an array of ".Phase::class." but found string inside.");

        // Act
        /** @var SynodicRhythm $synodic_rhythm */
        new FromSynodicRhythm($synodic_rhythm, ["NonExistentClass"]);
    }
}