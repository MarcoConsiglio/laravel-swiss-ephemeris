<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Anomalies;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;

abstract class AnomalisticStrategy implements BuilderStrategy
{
    /**
     * Longitude delta: It is used for an error biased search. 
     *
     * @var float $delta
     */
    protected static float $delta = 0.25;

    /**
     * Find an exact record.
     *
     * @return mixed
     */
    public abstract function found();

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