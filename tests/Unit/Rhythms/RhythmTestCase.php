<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms;

use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromRecords;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Goniometry\Angle;

class RhythmTestCase extends TestCase
{
    /**
     * The sampling rate of the ephemeris.
     *
     * @var integer
     */
    protected int $sampling_rate;

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
     * Gets a Moon SynodicRhythm of a full cycle.
     *
     * @return SynodicRhythm
     */
    protected function getSynodicRhythm(): SynodicRhythm
    {
        return new SynodicRhythm(
            new FromRecords([
                new SynodicRhythmRecord(
                    SwissEphemerisDateTime::create(2000, 1, 1),
                    Angle::createFromDecimal(0.0),
                    $this->getRandomDailySpeed()
                ),
                new SynodicRhythmRecord(
                    SwissEphemerisDateTime::create(2000, 1, 8),
                    Angle::createFromDecimal(90.0),
                    $this->getRandomDailySpeed()
                ),
                new SynodicRhythmRecord(
                    SwissEphemerisDateTime::create(2000, 1, 15),
                    Angle::createFromDecimal(180.0),
                    $this->getRandomDailySpeed()
                ),
                new SynodicRhythmRecord(
                    SwissEphemerisDateTime::create(2000, 1, 22),
                    Angle::createFromDecimal(-90),
                    $this->getRandomDailySpeed()
                )
                ]),
                $this->sampling_rate
        );
    }

    protected function getRandomDailySpeed(): float
    {
        return $this->faker->randomFloat(7, 10, 14);
    }
}