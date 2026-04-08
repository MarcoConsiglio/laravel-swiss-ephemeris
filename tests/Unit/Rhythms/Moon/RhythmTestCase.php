<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Moon;

use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromRecords;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\RhythmTestCase as GenericRhythmTestCase;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Enums\Direction;

class RhythmTestCase extends GenericRhythmTestCase
{
    /**
     * Get a Moon SynodicRhythm of a full cycle.
     */
    protected function getSynodicRhythm(): SynodicRhythm
    {
        return new SynodicRhythm(
            new FromRecords([
                new SynodicRhythmRecord(
                    SwissEphemerisDateTime::create(2000, 1, 1),
                    Angle::createFromValues(0),
                    $this->getRandomMoonDailySpeed()
                ),
                new SynodicRhythmRecord(
                    SwissEphemerisDateTime::create(2000, 1, 8),
                    Angle::createFromValues(90),
                    $this->getRandomMoonDailySpeed()
                ),
                new SynodicRhythmRecord(
                    SwissEphemerisDateTime::create(2000, 1, 15),
                    Angle::createFromValues(180),
                    $this->getRandomMoonDailySpeed()
                ),
                new SynodicRhythmRecord(
                    SwissEphemerisDateTime::create(2000, 1, 22),
                    Angle::createFromValues(90, direction: Direction::CLOCKWISE),
                    $this->getRandomMoonDailySpeed()
                )
            ]),
            $this->sampling_rate
        );
    }
}