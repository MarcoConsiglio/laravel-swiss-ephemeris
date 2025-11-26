<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Phases;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Enums\Moon\Phase;
use MarcoConsiglio\Ephemeris\Records\Moon\PhaseRecord;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromRecords;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\Phases\FromSynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Phases;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\BuilderTestCase;
use MarcoConsiglio\Goniometry\Angle;

#[TestDox("The Moon\Phases\FromMoonSynodicRhythm builder")]
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
        $synodic_month = 29.530588;
        $this->sampling_rate = $this->faker->numberBetween(30, intval($synodic_month / 4 * 24 * 60));
    }

    #[TestDox("can build a Moon\Phases collection from the Moon\SynodicRhythm.")]
    public function test_build_moon_phases_from_synodic_rhythm()
    {
        // Arrange
        $builder_class = $this->getBuilderClass();
        $record_class = PhaseRecord::class;
        $date_1 = SwissEphemerisDateTime::create("2021-10-06 11:00:00");
        $date_2 = SwissEphemerisDateTime::create("2021-10-13 03:00:00");
        $date_3 = SwissEphemerisDateTime::create("2021-10-20 15:00:00");
        $date_4 = SwissEphemerisDateTime::create("2021-10-28 20:00:00");
        $angle_1 = Angle::createFromDecimal(-0.0614509);
        $angle_2 = Angle::createFromDecimal(89.7644741);
        $angle_3 = Angle::createFromDecimal(-179.9831740);
        $angle_4 = Angle::createFromDecimal(-90.0499896);
        $daily_speed_1 = $this->faker->randomFloat(7, 10, 14);
        $daily_speed_2 = $this->faker->randomFloat(7, 10, 14);
        $daily_speed_3 = $this->faker->randomFloat(7, 10, 14);
        $daily_speed_4 = $this->faker->randomFloat(7, 10, 14);
        $new_moon_record = new SynodicRhythmRecord($date_1, $angle_1, $daily_speed_1);
        $first_quarter_record = new SynodicRhythmRecord($date_2, $angle_2, $daily_speed_2);
        $full_moon_record = new SynodicRhythmRecord($date_3, $angle_3, $daily_speed_3);
        $third_quarter_record = new SynodicRhythmRecord($date_4, $angle_4, $daily_speed_4);
        $synodic_rhythm_builder = new FromRecords([
            $new_moon_record,
            $first_quarter_record,
            $full_moon_record,
            $third_quarter_record
        ]);
        $synodic_rhythm = new SynodicRhythm($synodic_rhythm_builder, $this->sampling_rate);

        // Act
        /** @var SynodicRhythm $synodic_rhythm */
        $builder = new $builder_class($synodic_rhythm, Phase::cases(), $this->sampling_rate);
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
        
        // Act
        /** @var SynodicRhythm $synodic_rhythm */
        new FromSynodicRhythm($synodic_rhythm, [], $this->sampling_rate);
    }

    #[TestDox("can build only with Moon\Phase constants.")]
    public function test_needs_only_moon_phase_type()
    {
        // Arrange
        $synodic_rhythm = $this->getMocked(SynodicRhythm::class);

        // Assert
        $this->expectException(InvalidArgumentException::class);

        // Act
        /** @var SynodicRhythm $synodic_rhythm */
        new FromSynodicRhythm($synodic_rhythm, ["NonExistentClass"], $this->sampling_rate);
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
}