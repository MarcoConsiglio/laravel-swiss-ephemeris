<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms;

use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromRecords;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;

abstract class RhythmTestCase extends TestCase
{
    /**
     * Setup the test environment.
     */
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->sampling_rate = 60;
    }
}