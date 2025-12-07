<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms;

use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromRecords;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Goniometry\Angle;

abstract class RhythmTestCase extends TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->sampling_rate = 60;
    }

    /**
     * Get a Moon SynodicRhythm of a full cycle.
     *
     * @return SynodicRhythm
     */
    protected function getSynodicRhythm(): SynodicRhythm
    {
        return new SynodicRhythm(
            new FromRecords([
                new SynodicRhythmRecord(
                    SwissEphemerisDateTime::create(2000, 1, 1),
                    $this->getSpecificAngle(0),
                    $this->getRandomMoonDailySpeed()
                ),
                new SynodicRhythmRecord(
                    SwissEphemerisDateTime::create(2000, 1, 8),
                    $this->getSpecificAngle(90),
                    $this->getRandomMoonDailySpeed()
                ),
                new SynodicRhythmRecord(
                    SwissEphemerisDateTime::create(2000, 1, 15),
                    $this->getSpecificAngle(180),
                    $this->getRandomMoonDailySpeed()
                ),
                new SynodicRhythmRecord(
                    SwissEphemerisDateTime::create(2000, 1, 22),
                    $this->getSpecificAngle(-90),
                    $this->getRandomMoonDailySpeed()
                )
                ]),
                $this->sampling_rate
        );
    }

    /**
     * Get a fake lunar daily speed expressed in degrees per day.
     * 
     * @return float
     */
    protected function getRandomMoonDailySpeed(): float
    {
        return $this->getRandomSpeed(10, 14);
    }
}