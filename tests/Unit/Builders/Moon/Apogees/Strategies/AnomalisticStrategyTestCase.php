<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\Moon\Apogees\Strategies;

use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Tests\Unit\Builders\StrategyTestCase;
use MarcoConsiglio\Goniometry\Angle;

class AnomalisticStrategyTestCase extends StrategyTestCase
{
    /**
     * Gets an ApogeeRecord with the Moon close to its apogee.
     *
     * @param integer $longitude Moon and apogee longitude.
     * @return ApogeeRecord
     */
    protected function getApogeeRecord(float $longitude = 180.0): ApogeeRecord
    {
        $moon_longitude = Angle::createFromDecimal($this->getBiasedAngularDistance($longitude));
        $apogee_longitude = Angle::createFromDecimal($this->getBiasedAngularDistance($longitude));
        return new ApogeeRecord(
            $this->date,
            $moon_longitude,
            $apogee_longitude
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
        $moon_longitude = Angle::createFromDecimal($this->getBiasedAngularDistance($longitude));
        $apogee_longitude = Angle::createFromDecimal($this->getBiasedAngularDistanceExceptFor($longitude));
        return new ApogeeRecord(
            $this->date,
            $moon_longitude,
            $apogee_longitude
        );
    }

    /**
     * Constructs the strategy to test.
     *
     * @param string $strategy
     * @param SynodicRhythmRecord $record
     * @return BuilderStrategy
     */
    protected function makeStrategy(ApogeeRecord $record): BuilderStrategy
    {
        $class = $this->tested_class;
        return new $class($record);
    }
}