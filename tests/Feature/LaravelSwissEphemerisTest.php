<?php

namespace MarcoConsiglio\Ephemeris\Tests\Feature;;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Exceptions\SwissEphemerisError;
use MarcoConsiglio\Ephemeris\LaravelSwissEphemeris;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\AnomalisticRhythm;
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
    public function test_moon_synodic_rhythm()
    {
        // Arrange in setUp()

        // Act
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm(SwissEphemerisDateTime::create(2000));

        // Assert
        $this->assertInstanceOf(SynodicRhythm::class, $synodic_rhythm, 
            $this->methodMustReturn(
                LaravelSwissEphemeris::class, 
                "getMoonSynodicRhythm", 
                SynodicRhythm::class
        ));
        $this->assertContainsOnlyInstancesOf(SynodicRhythmRecord::class, $synodic_rhythm, 
            $this->iterableMustContains(SynodicRhythm::class, SynodicRhythmRecord::class)    
        );
        $this->assertCount(720, $synodic_rhythm, 
            "In this test, the SynodicRhythm must contain 720 SynodicRhythmRecord instances."
        );
    }

    #[TestDox("can query the Moon anomalistic rhythm.")]
    public function test_moon_anomalistic_rhythm()
    {
        // Arrange in setUp()

        // Act
        $anomalistic_rhythm = $this->ephemeris->getMoonAnomalisticRhythm(SwissEphemerisDateTime::create(2000));

        // Assert
        $this->assertInstanceOf(AnomalisticRhythm::class, $anomalistic_rhythm,
            $this->methodMustReturn(
                LaravelSwissEphemeris::class, 
                "getMoonAnomalisticRhythm", 
                AnomalisticRhythm::class
        ));
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
