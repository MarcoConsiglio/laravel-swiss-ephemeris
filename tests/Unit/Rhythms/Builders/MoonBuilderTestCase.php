<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders;

use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;

abstract class MoonBuilderTestCase extends BuilderTestCase
{
    /**
     * Return a random Moon daily speed expressed in 
     * decimal degrees per day.
     *
     * @return float
     */
    protected function getRandomMoonDailySpeed(): float
    {
        return $this->getRandomSpeed(10, 14);
    }

    /**
     * It creates a specific Moon SynodicRhythmRecord.
     *
     * @param float $angular_distance The angular difference between the Moon and the Sun.
     * @return SynodicRhythmRecord
     */
    protected function getSpecificSynodicRhythmRecord(float $angular_distance): SynodicRhythmRecord
    {
        if ($angular_distance > 180) $angular_distance = 180;
        if ($angular_distance < -180) $angular_distance = -180;
        return new SynodicRhythmRecord(
            $this->getRandomSwissEphemerisDateTime(),
            $this->getSpecificAngle($angular_distance),
            $this->getRandomMoonDailySpeed()
        );
    }
}