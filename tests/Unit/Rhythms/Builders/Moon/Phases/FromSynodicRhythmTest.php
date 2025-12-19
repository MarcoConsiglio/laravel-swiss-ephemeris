<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Phases;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Enums\Moon\Phase;
use MarcoConsiglio\Ephemeris\Records\Moon\PhaseRecord;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromRecords;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\Phases\FromSynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Phases;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\BuilderTestCase;
use MarcoConsiglio\Goniometry\Angle;
use stdClass;
use PHPUnit\Framework\MockObject\MockObject;

#[TestDox("The Moon Phases\FromMoonSynodicRhythm builder")]
#[CoversClass(FromSynodicRhythm::class)]
#[UsesClass(Angle::class)]
#[UsesClass(FromRecords::class)]
#[UsesClass(Phases::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
#[UsesClass(SynodicRhythm::class)]
#[UsesClass(SynodicRhythmRecord::class)]
class FromSynodicRhythmTest extends BuilderTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->sampling_rate = $this->faker->numberBetween(30, 1440);
    }

    #[TestDox("can build a Moon\Phases collection from The Moon SynodicRhythm.")]
    public function test_build_moon_phases_from_synodic_rhythm()
    {
        // Arrange
        $builder_class = $this->getBuilderClass();
        $record_class = PhaseRecord::class;
        $synodic_rhythm_builder = new FromRecords([
            $this->getSpecificSynodicRhythmRecord(0),
            $this->getSpecificSynodicRhythmRecord(90),
            $this->getSpecificSynodicRhythmRecord($this->faker->randomElement([-180, 180])),
            $this->getSpecificSynodicRhythmRecord(-90)
        ]);
        $this->checkBuilderInterface(Builder::class, $synodic_rhythm_builder);
        $synodic_rhythm = new SynodicRhythm($synodic_rhythm_builder, $this->sampling_rate);

        // Act
        $builder = new $builder_class($synodic_rhythm, Phase::cases(), $this->sampling_rate);
        $moon_phases = $builder->fetchCollection();
        
        // Assert
        $this->assertIsArray($moon_phases,
            $this->methodMustReturn($builder_class, "fetchCollection", "array")
        );
        $this->assertContainsOnlyInstancesOf($record_class, $moon_phases,
            $this->iterableMustContains("array", $record_class)
        );
    }

    #[TestDox("cannot build without Moon\Phase constants.")]
    public function test_needs_at_least_one_moon_phase_type()
    {
        // Arrange
        $builder_class = $this->getBuilderClass();
        $phase_class = Phase::class;
        $phase_collection_class = Phases::class;
        $synodic_rhythm = $this->getMocked(SynodicRhythm::class);

        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            "The $builder_class builder needs at least a $phase_class enum constant to construct a $phase_collection_class collection."
        );
        
        // Act
        /** @var SynodicRhythm $synodic_rhythm */
        new FromSynodicRhythm($synodic_rhythm, [], $this->sampling_rate);
    }

    #[TestDox("can build only with Moon\Phase constants.")]
    public function test_needs_only_moon_phase_type()
    {
        // Arrange
        /** @var SynodicRhythm&MockObject $synodic_rhythm */
        $synodic_rhythm = $this->getMocked(SynodicRhythm::class);
        $phase_class = Phase::class;

        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Parameter 2 must be an array of $phase_class but found ".stdClass::class." inside.");

        // Act
        new FromSynodicRhythm($synodic_rhythm, [new stdClass], $this->sampling_rate);
    }

    /**
     * Get the current SUT class.
     * 
     * @return string
     */
    protected function getBuilderClass(): string
    {
        return FromSynodicRhythm::class;  
    }

    /**
     * Create a specific Moon SynodicRhythmRecord.
     *
     * @param float $angular_distance The angular difference between the Moon and the Sun.
     * @return SynodicRhythmRecord
     */
    protected function getSpecificSynodicRhythmRecord(float $angular_distance): SynodicRhythmRecord
    {
        if ($angular_distance > 180) $angular_distance = 180;
        if ($angular_distance < -180) $angular_distance = -180;
        return new SynodicRhythmRecord(
            $this->getRandomSwissEphemerisDateTime(),
            $this->getSpecificAngle($angular_distance),
            $this->getRandomMoonDailySpeed()
        );
    }
}