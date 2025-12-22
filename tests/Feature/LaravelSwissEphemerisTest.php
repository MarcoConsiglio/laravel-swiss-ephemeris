<?php

namespace MarcoConsiglio\Ephemeris\Tests\Feature;;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\LaravelSwissEphemeris;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\AnomalisticRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\DraconicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
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
        // Act
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm($this->getRandomSwissEphemerisDateTime());

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
        // Act
        $anomalistic_rhythm = $this->ephemeris->getMoonAnomalisticRhythm($this->getRandomSwissEphemerisDateTime());

        // Assert
        $this->assertInstanceOf(AnomalisticRhythm::class, $anomalistic_rhythm,
            $this->methodMustReturn(
                LaravelSwissEphemeris::class, 
                "getMoonAnomalisticRhythm", 
                AnomalisticRhythm::class
        ));
    }

    #[TestDox("can query the Moon draconic rhythm.")]
    public function test_moon_draconic_rhythm()
    {
        // Act
        $draconic_rhythm = $this->ephemeris->getMoonDraconicRhythm($this->getRandomSwissEphemerisDateTime());

        // Assert
        $this->assertInstanceOf(DraconicRhythm::class, $draconic_rhythm,
            $this->methodMustReturn(LaravelSwissEphemeris::class,
                "getMoonDraconicRhythm",
                DraconicRhythm::class
            )
        );
    }
}
