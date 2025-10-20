<?php
namespace MarcoConsiglio\Ephemeris\Tests\Feature;

use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPhaseRecord;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPhases;
use MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythm;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\CoversClass;

#[TestDox("A MoonPhases collection")]
#[CoversClass(MoonPhases::class)]
class MoonPhasesTest extends TestCase
{
    #[TestDox("is a Collection containing MoonPhaseRecord(s).")]
    public function test_moon_phases()
    {
        // Arrange
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm(new SwissEphemerisDateTime("now"), 24);
        $rhythm_class = MoonSynodicRhythm::class;
        $laravel_collection_class = Collection::class;
        $collection_class = MoonPhases::class;
        $collection_record_class = MoonPhaseRecord::class;

        // Act
        $moon_phases = $synodic_rhythm->getPhases(MoonPhaseType::cases());

        // Assert
        $this->assertInstanceOf($laravel_collection_class, $moon_phases, 
            "The $collection_class class must extend $laravel_collection_class."
        );
        $this->assertInstanceOf($collection_class, $moon_phases, 
            "The $rhythm_class::getPhases() method must return a $collection_class collection instance.");
        $this->assertContainsOnlyInstancesOf($collection_record_class, $moon_phases, 
            "The $collection_class collection class must contains only $collection_record_class instances.");
    }
}