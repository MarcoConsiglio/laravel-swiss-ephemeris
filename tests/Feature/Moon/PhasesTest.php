<?php
namespace MarcoConsiglio\Ephemeris\Tests\Feature\Moon;

use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Records\Moon\PhaseRecord;
use MarcoConsiglio\Ephemeris\Enums\Moon\Phase;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Phases;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\CoversClass;

#[TestDox("The Moon\Phases")]
#[CoversClass(Phases::class)]
class PhasesTest extends TestCase
{
    #[TestDox("is a collection of Moon\PhaseRecord instances.")]
    public function test_moon_phases()
    {
        // Arrange
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm(new SwissEphemerisDateTime("now"), 24);
        $rhythm_class = SynodicRhythm::class;
        $laravel_collection_class = Collection::class;
        $collection_class = Phases::class;
        $collection_record_class = PhaseRecord::class;

        // Act
        $moon_phases = $synodic_rhythm->getPhases(Phase::cases());

        // Assert
        $this->assertInstanceOf($laravel_collection_class, $moon_phases, 
            "The $collection_class class must extend $laravel_collection_class."
        );
        $this->assertInstanceOf($collection_class, $moon_phases, 
            "The $rhythm_class::getPhases() method must return a $collection_class instance.");
        $this->assertContainsOnlyInstancesOf($collection_record_class, $moon_phases, 
            "The $collection_class collection class must contains only $collection_record_class instances.");
    }
}