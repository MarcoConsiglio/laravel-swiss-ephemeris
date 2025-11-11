<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Traits\WithFuzzyCondition;

/**
 * The abstract strategy used to build a rhythm.
 * 
 * Implemented in a concrete strategy defines the algorithm
 * used to choose which record would be part of the rhythm,
 * and which not.
 * 
 * @property float $delta The error bias used to accept the correct record.
 */
abstract class Strategy implements BuilderStrategy
{
    use WithFuzzyCondition;

    /**
     * Angular distance delta: It is used for an error biased search. 
     *
     * @var float $delta
     */
    public protected(set) float $delta = 0.25 {
        get { return $this->delta; }
        set(float $value) { $this->delta = abs($value); }
    }

    /**
     * Find an exact record.
     *
     * @return mixed
     */
    abstract public function found();
}