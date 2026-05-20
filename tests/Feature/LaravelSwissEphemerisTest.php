<?php

namespace MarcoConsiglio\Ephemeris\Tests\Feature;;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\LaravelSwissEphemeris;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\AnomalisticRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\DraconicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm as MoonSynodicRhythm;

#[TestDox("The Laravel Swiss Ephemeris")]
#[CoversClass(LaravelSwissEphemeris::class)]
class LaravelSwissEphemerisTest extends TestCase
{
    #[TestDox("can query the Moon synodic rhythm.")]
    public function test_moon_synodic_rhythm(): void
    {
        // Act
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm($this->randomSwissEphemerisDateTime());

        // Assert
        $this->assertInstanceOf(MoonSynodicRhythm::class, $synodic_rhythm, 
            $this->methodMustReturn(
                LaravelSwissEphemeris::class, 
                "getMoonSynodicRhythm", 
                MoonSynodicRhythm::class
        ));
        $this->assertContainsOnlyInstancesOf(SynodicRhythmRecord::class, $synodic_rhythm, 
            $this->iterableMustContains(MoonSynodicRhythm::class, SynodicRhythmRecord::class)    
        );
        $this->assertCount(720, $synodic_rhythm, 
            "In this test, the SynodicRhythm must contain 720 SynodicRhythmRecord instances."
        );
    }

    #[TestDox("can query the Moon anomalistic rhythm.")]
    public function test_moon_anomalistic_rhythm(): void
    {
        // Act
        $anomalistic_rhythm = $this->ephemeris->getMoonAnomalisticRhythm($this->randomSwissEphemerisDateTime());

        // Assert
        $this->assertInstanceOf(AnomalisticRhythm::class, $anomalistic_rhythm,
            $this->methodMustReturn(
                LaravelSwissEphemeris::class, 
                "getMoonAnomalisticRhythm", 
                AnomalisticRhythm::class
        ));
    }

    #[TestDox("can query the Moon draconic rhythm.")]
    public function test_moon_draconic_rhythm(): void
    {
        // Act
        $draconic_rhythm = $this->ephemeris->getMoonDraconicRhythm($this->randomSwissEphemerisDateTime());

        // Assert
        $this->assertInstanceOf(DraconicRhythm::class, $draconic_rhythm,
            $this->methodMustReturn(LaravelSwissEphemeris::class,
                "getMoonDraconicRhythm",
                DraconicRhythm::class
            )
        );
    }
}
