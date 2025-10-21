<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;

/**
 * Describe a strategy used to find a moon phase.
 * 
 * @property-read float $delta Angular distance delta: It is used for an error biased search. 
 */
abstract class MoonPhaseStrategy implements BuilderStrategy
{
    /**
     * Angular distance delta: It is used for an error biased search. 
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