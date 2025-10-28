<?php

namespace MarcoConsiglio\Ephemeris\Tests\Feature;;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Exceptions\SwissEphemerisError;
use MarcoConsiglio\Ephemeris\LaravelSwissEphemeris;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The Laravel Swiss Ephemeris")]
#[CoversClass(LaravelSwissEphemeris::class)]
#[UsesClass(SynodicRhythm::class)]
#[UsesClass(SynodicRhythmRecord::class)]
class LaravelSwissEphemerisTest extends TestCase
{
    #[TestDox("can query the Moon synodic rhythm.")]
    public function test_synodic_rhythm()
    {
        // Arrange in setUp()

        // Act
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm(SwissEphemerisDateTime::create(2000));

        // Assert
        $this->assertInstanceOf(SynodicRhythm::class, $synodic_rhythm, 
            "The synodic_rhythm should be a Collection instance, but ".gettype($synodic_rhythm)." found.");
        $this->assertContainsOnlyInstancesOf(SynodicRhythmRecord::class, $synodic_rhythm, 
            "A MoonSynodicRhythm must contains only MoonSynodicRhythmRecord(s).");
    }

    #[TestDox("throw an Exception if the query is outbound the available time range.")]
    public function test_outbound_time_range_throw_exception()
    {
        // Arrange in setUp()
        $this->markTestSkipped("Need better checks errors and warning in the raw output.");
        // Assert
        $this->expectException(SwissEphemerisError::class);

        // Act
        $this->ephemeris->getMoonSynodicRhythm(SwissEphemerisDateTime::create(0), -1, -5);
    }
}
