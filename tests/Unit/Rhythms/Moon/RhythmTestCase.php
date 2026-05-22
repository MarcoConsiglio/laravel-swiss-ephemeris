<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Moon;

use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromRecords;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\RhythmTestCase as GenericRhythmTestCase;
use MarcoConsiglio\Goniometry\AngularDistance;

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
                    AngularDistance::createFromDecimal(0),
                    $this->randomMoonDailySpeed()
                ),
                new SynodicRhythmRecord(
                    SwissEphemerisDateTime::create(2000, 1, 8),
                    AngularDistance::createFromDecimal(90),
                    $this->randomMoonDailySpeed()
                ),
                new SynodicRhythmRecord(
                    SwissEphemerisDateTime::create(2000, 1, 15),
                    AngularDistance::createFromDecimal(180),
                    $this->randomMoonDailySpeed()
                ),
                new SynodicRhythmRecord(
                    SwissEphemerisDateTime::create(2000, 1, 22),
                    AngularDistance::createFromDecimal(-90),
                    $this->randomMoonDailySpeed()
                )
            ]),
            $this->sampling_rate
        );
    }
}