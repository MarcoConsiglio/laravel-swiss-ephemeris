<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms;

use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromRecords;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Goniometry\Angle;

class RhythmTestCase extends TestCase
{
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
                    $this->getSwissEphemerisDateTime(2000, 1, 1),
                    Angle::createFromDecimal(0.0)
                ),
                new SynodicRhythmRecord(
                    $this->getSwissEphemerisDateTime(2000, 1, 8),
                    Angle::createFromDecimal(90.0)
                ),
                new SynodicRhythmRecord(
                    $this->getSwissEphemerisDateTime(2000, 1, 15),
                    Angle::createFromDecimal(180.0)
                ),
                new SynodicRhythmRecord(
                    $this->getSwissEphemerisDateTime(2000, 1, 22),
                    Angle::createFromDecimal(-90)
                )
            ])
        );
    }
}