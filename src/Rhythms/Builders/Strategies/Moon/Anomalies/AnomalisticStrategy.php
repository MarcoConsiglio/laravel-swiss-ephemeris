<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Anomalies;

use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Strategy;

/**
 * Describes a strategy used to found a record of the Moon anomalistic rhythm.
 */
abstract class AnomalisticStrategy extends Strategy
{
    protected ApogeeRecord $record;

    /**
     * Find an exact record.
     *
     * @return mixed
     */
    abstract public function found();

    /**
     * Gets the delta specified by the strategy.
     *
     * @return float
     */
    public static function getDelta(): float
    {
        return self::$delta;
    }
}