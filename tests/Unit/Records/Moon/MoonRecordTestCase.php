<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Records\Moon;

use MarcoConsiglio\Ephemeris\Tests\Unit\Records\RecordTestCase;

abstract class MoonRecordTestCase extends RecordTestCase
{

    /**
     * Return a random daily speed 
     *
     * @return float
     */
    protected function getRandomMoonDailySpeed(): float
    {
        return $this->getRandomSpeed(10, 14);
    }
}