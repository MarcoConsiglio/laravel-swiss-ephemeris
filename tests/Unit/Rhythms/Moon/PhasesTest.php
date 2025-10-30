<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Moon;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\Enums\Moon\Phase;
use MarcoConsiglio\Ephemeris\Records\Moon\PhaseRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Phases\FromSynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Phases;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\RhythmTestCase;

#[TestDox("The Moon\Phases collection")]
#[CoversClass(Phases::class)]
#[UsesClass(PhaseRecord::class)]
#[UsesClass(Phase::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
class PhasesTest extends RhythmTestCase
{
    #[TestDox("is a collection of Moon\PhaseRecord instances.")]
    public function test_moon_phases()
    {
        // Arrange
        $date = SwissEphemerisDateTime::create(2000);
        /** @var FromSynodicRhythm&MockObject */
        $phases_builder = $this->getMocked(FromSynodicRhythm::class);
        $phases_builder->expects($this->once())->method("fetchCollection")->willReturn([
            new PhaseRecord($date, Phase::NewMoon),
            new PhaseRecord($date, Phase::FirstQuarter),
            new PhaseRecord($date, Phase::FullMoon),
            new PhaseRecord($date, Phase::ThirdQuarter)
        ]);

        // Act
        $phases = new Phases($phases_builder);

        // Assert
        $this->assertContainsOnlyInstancesOf(PhaseRecord::class, $phases);
    }

    #[TestDox("can return a specific Moon\PhaseRecord instance.")]
    public function test_getters()
    {
        // Arrange
        $synodic_rhythm = $this->getSynodicRhythm();
        $phases_builder = new FromSynodicRhythm($synodic_rhythm, Phase::cases());
        $phases = new Phases($phases_builder);

        // Act
        $first_record = $phases->first();
        $last_record = $phases->last();
        $a_record = $phases->get(1);

        // Assert
        $this->assertInstanceOf(PhaseRecord::class, $first_record,
            $this->methodMustReturn(Phases::class, "first", PhaseRecord::class)
        );
        $this->assertInstanceOf(PhaseRecord::class, $last_record,
            $this->methodMustReturn(Phases::class, "last", PhaseRecord::class)
        );
        $this->assertInstanceOf(PhaseRecord::class, $a_record,
            $this->methodMustReturn(Phases::class, "get", PhaseRecord::class)
        );
    }
}