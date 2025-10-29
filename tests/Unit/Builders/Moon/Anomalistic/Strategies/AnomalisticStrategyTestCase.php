<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\Moon\Anomalistic\Strategies;

use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Tests\Unit\Builders\StrategyTestCase;
use MarcoConsiglio\Goniometry\Angle;

class AnomalisticStrategyTestCase extends StrategyTestCase
{
    /**
     * Gets a biased Angle with $longitude.
     *
     * @param float $longitude
     * @return Angle
     */
    private function getLongitude(float $longitude = 180.0): Angle
    {
        return Angle::createFromDecimal($this->getBiasedAngularDistance($longitude));
    }

    /**
     * Gets a biased Angle fexcept for $longitude.
     *
     * @param float $longitude
     * @return Angle
     */
    private function getLongitudeExceptFor(float $longitude = 180.0): Angle
    {
        return Angle::createFromDecimal($this->getBiasedAngularDistanceExceptFor($longitude));
    }

    /**
     * Gets an ApogeeRecord with the Moon close to its apogee.
     *
     * @param integer $longitude Moon and apogee longitude.
     * @return ApogeeRecord
     */
    protected function getApogeeRecord(float $longitude = 180.0): ApogeeRecord
    {
        $moon_longitude = $this->getLongitude($longitude);
        $apogee_longitude = $this->getLongitude($longitude);
        return new ApogeeRecord(
            $this->date,
            $moon_longitude,
            $apogee_longitude
        );
    }

    /**
     * Gets an PerigeeRecord with the Moon close to its perigee.
     *
     * @param integer $longitude Moon and perigee longitude.
     * @return PerigeeRecord
     */
    protected function getPerigeeRecord(float $longitude = 180.0): PerigeeRecord
    {
        $moon_longitude = $this->getLongitude($longitude);
        $perigee_longitude = $this->getLongitude($longitude);
        return new PerigeeRecord(
            $this->date,
            $moon_longitude,
            $perigee_longitude
        );
    }

    /**
     * Gets an ApogeeRecord with the Moon too far from its apogee.
     *
     * @param float $longitude The Moon longitude, but not the apogee longitude.
     * @return ApogeeRecord
     */
    protected function getNonApogeeRecord(float $longitude = 180.0): ApogeeRecord
    {
        $moon_longitude = $this->getLongitude($longitude);
        $apogee_longitude = $this->getLongitudeExceptFor($longitude);
        return new ApogeeRecord(
            $this->date,
            $moon_longitude,
            $apogee_longitude
        );
    }

    /**
     * Gets an PerigeeRecord with the Moon too far from its perigee.
     *
     * @param float $longitude The Moon longitude, but not the perigee longitude.
     * @return PerigeeRecord
     */
    protected function getNonPerigeeRecord(float $longitude = 180.0): PerigeeRecord
    {
        $moon_longitude = $this->getLongitude($longitude);
        $perigee_longitude = $this->getLongitudeExceptFor($longitude);
        return new PerigeeRecord(
            $this->date,
            $moon_longitude,
            $perigee_longitude
        );
    }

    /**
     * Constructs the strategy to test.
     *
     * @param string $strategy
     * @param ApogeeRecord|PerigeeRecord $record
     * @return BuilderStrategy
     */
    protected function makeStrategy(ApogeeRecord|PerigeeRecord $record): BuilderStrategy
    {
        $class = $this->tested_class;
        return new $class($record);
    }
}