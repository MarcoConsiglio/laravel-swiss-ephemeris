<?php

namespace MarcoConsiglio\Ephemeris\Tests\Feature;;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;

/**
 * @testdox The SynodicRhythm collection
 */
class SynodicRhythmTest extends TestCase
{
    use WithFaker;

    /**
     * @testdox consists of SynodicRhythmRecord instances.
     */
    public function test_synodic_rhythm_has_records()
    {
        // Arrange in setUp()
     
        // Act
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm(new Carbon, $days = 1);
        $record = $synodic_rhythm->get($this->faker->numberBetween(0, $synodic_rhythm->count() - 1));

        // Assert
        $this->assertInstanceOf(SynodicRhythm::class, $synodic_rhythm);
        $this->assertContainsOnlyInstancesOf(SynodicRhythmRecord::class, $synodic_rhythm, 
            "SynodicRhythm must contain SynodicRhythmRecords.");
        $this->assertEquals(24 * $days, $count = count($synodic_rhythm), 
            "The total of records must be 24 x $days = ".(24*$days).". Found $count records.");
        $this->assertInstanceOf(SynodicRhythmRecord::class, $record, "The getter must return a SynodicRhythmRecord.");
    }

    /**
     * @testdox cannot be constructed with empty records.
     */
    public function test_synodic_rhythm_throw_exception_if_records_are_empty()
    {
        // Arrange
        $empty_records = [];

        // Act & Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The SynodicRhythm must be constructed with SynodicRhythmRecord(s) or an array with 'timestamp' and 'angular_distance' setted.");
        new SynodicRhythm($empty_records);
    }

    /**
     * @testdox can give you the first and last SynodicRhythmRecord.
     */
    public function test_synodic_rhythm_has_first_and_last_getter()
    {
        // Arrange
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm(new Carbon("2000-01-01"), 1);

        // Act
        $last = $synodic_rhythm->last();

        // Assert
        $this->assertInstanceOf(SynodicRhythmRecord::class, $last, "The SynodicRhythm last getter must return a SynodicRhythmRecord instance.");
    }
}
