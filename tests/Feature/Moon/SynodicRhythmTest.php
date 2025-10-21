<?php

namespace MarcoConsiglio\Ephemeris\Tests\Feature\Moon;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Enums\Moon\Phase;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Periods;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Phases;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The Moon\SynodicRhythm collection")]
#[CoversClass(SynodicRhythm::class)]
class SynodicRhythmTest extends TestCase
{
    use WithFaker;

    #[TestDox("consists of Moon\SynodicRhythmRecord instances.")]
    public function test_synodic_rhythm_has_records()
    {
        // Arrange in setUp()
     
        // Act
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm(new Carbon, $days = 1);
        $record = $synodic_rhythm->get($this->faker->numberBetween(0, $synodic_rhythm->count() - 1));

        // Assert
        $this->assertInstanceOf(SynodicRhythm::class, $synodic_rhythm);
        $this->assertContainsOnlyInstancesOf(SynodicRhythmRecord::class, $synodic_rhythm, 
            "MoonSynodicRhythm must contain MoonSynodicRhythmRecords.");
        $this->assertEquals(24 * $days, $count = count($synodic_rhythm), 
            "The total of records must be 24 x $days = ".(24*$days).". Found $count records.");
        $this->assertInstanceOf(SynodicRhythmRecord::class, $record, "The getter must return a MoonSynodicRhythmRecord.");
    }

    #[TestDox("can return a MoonPeriods collection.")]
    public function test_return_moon_periods_collection()
    {
        // Arrange in setUp()
        $moon_periods_collection_class = Periods::class;
        
        // Act
        $moon_synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm(new SwissEphemerisDateTime("now"));
        $moon_periods = $moon_synodic_rhythm->getPeriods();
        
        // Assert
        $actual_class = $moon_periods::class;
        $failure_message = $this->instanceTypeFail($moon_periods_collection_class, $actual_class);
        $this->assertInstanceOf($moon_periods_collection_class, $moon_periods, $failure_message);
    }

    #[TestDox("can return a MoonPhases collection.")]
    public function test_return_moon_phases_collection()
    {
        // Arrange in setUp()
        $moon_phases_collection_class = Phases::class;

        // Act
        $moon_synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm(new SwissEphemerisDateTime("now"));
        $moon_phases = $moon_synodic_rhythm->getPhases(Phase::cases());

        // Assert
        $actual_class = $moon_phases::class;
        $failure_message = $this->instanceTypeFail($moon_phases_collection_class, $actual_class);
        $this->assertInstanceOf($moon_phases_collection_class, $moon_phases, $failure_message);
    }

    #[TestDox("cannot be constructed with empty records.")]
    public function test_synodic_rhythm_throw_exception_if_records_are_empty()
    {
        // Arrange
        $empty_records = [];

        // Act & Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The MoonSynodicRhythm must be constructed with MoonSynodicRhythmRecord(s) or an array with 'timestamp' and 'angular_distance' setted.");
        new SynodicRhythm($empty_records);
    }

    #[TestDox("can give you the first and last MoonSynodicRhythmRecord.")]
    public function test_synodic_rhythm_has_first_and_last_getter()
    {
        // Arrange
        $moon_synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm(new Carbon("now"));
        $expected_class = SynodicRhythmRecord::class;

        // Act
        $first = $moon_synodic_rhythm->first();
        $last = $moon_synodic_rhythm->last();

        // Assert
        $class_of_first_record = $first::class;
        $class_of_last_record = $last::class;
        $this->assertInstanceOf(SynodicRhythmRecord::class, $first, 
            $this->instanceTypeFail($expected_class, $class_of_first_record));
        $this->assertInstanceOf(SynodicRhythmRecord ::class, $last, 
            $this->instanceTypeFail($expected_class, $class_of_last_record));
    }
}
