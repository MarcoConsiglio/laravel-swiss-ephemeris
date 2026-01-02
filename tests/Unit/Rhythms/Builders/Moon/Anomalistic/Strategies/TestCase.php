<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Anomalistic\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\StrategyTestCase;

class TestCase extends StrategyTestCase
{
    /**
     * Return an ApogeeRecord with the Moon close to its apogee.
     *
     * @param integer $longitude Moon and apogee longitude.
     */
    protected function getApogeeRecord(float $longitude = 180.0): ApogeeRecord
    {
        $moon_longitude = $this->getLongitude($longitude);
        $apogee_longitude = Angle::createFromDecimal($longitude);
        return new ApogeeRecord(
            $this->date,
            $moon_longitude,
            $apogee_longitude,
            $this->daily_speed
        );
    }

    /**
     * Return an PerigeeRecord with the Moon close to its perigee.
     *
     * @param integer $longitude Moon and perigee longitude.
     */
    protected function getPerigeeRecord(float $longitude = 180.0): PerigeeRecord
    {
        $moon_longitude = $this->getLongitude($longitude);
        $perigee_longitude = Angle::createFromDecimal($longitude);
        return new PerigeeRecord(
            $this->date,
            $moon_longitude,
            $perigee_longitude,
            $this->daily_speed
        );
    }

    /**
     * Return an ApogeeRecord with the Moon that isn't in its apogee.
     *
     * @param float $longitude The Moon longitude, but not the apogee longitude.
     */
    protected function getNonApogeeRecord(float $longitude = 180.0): ApogeeRecord
    {
        $moon_longitude = $this->getLongitude($longitude);
        $apogee_longitude = $this->getLongitudeExceptFor($longitude);
        return new ApogeeRecord(
            $this->date,
            $moon_longitude,
            $apogee_longitude,
            $this->daily_speed
        );
    }

    /**
     * Return a PerigeeRecord with the Moon that isn't in its perigee.
     *
     * @param float $longitude The Moon longitude, but not the perigee longitude.
     */
    protected function getNonPerigeeRecord(float $longitude = 180.0): PerigeeRecord
    {
        $moon_longitude = $this->getLongitude($longitude);
        $perigee_longitude = $this->getLongitudeExceptFor($longitude);
        return new PerigeeRecord(
            $this->date,
            $moon_longitude,
            $perigee_longitude,
            $this->daily_speed
        );
    }

    /**
     * Construct the strategy to test.
     *
     * @param string $strategy
     */
    protected function makeStrategy(ApogeeRecord|PerigeeRecord $record): BuilderStrategy
    {
        $class = $this->tested_class;
        return new $class($record, $this->sampling_rate);
    }
}