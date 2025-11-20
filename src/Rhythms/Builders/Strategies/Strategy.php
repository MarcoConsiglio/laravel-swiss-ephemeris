<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Traits\WithFuzzyLogic;
use MarcoConsiglio\Goniometry\Angle;

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
    use WithFuzzyLogic;

    /**
     * Angular distance delta expressed as a decimal number: It 
     * is used for an error biased search. 
     * 
     * Warning! Changing this value cause unpredictable behaviour 
     * in rhythms builders. This value is related to the ephemeris 
     * sampling rate. This value should be adjusted accordingly.
     * The ephemeris sampling rate is currently set to 60 minutes 
     * by default in this software. Changing the sampling rate causes 
     * the same unpredictability effects as changing the value of 
     * $delta. This problem could be solved by developing an algorithm 
     * that, given a sampling frequency and the angular velocity of the 
     * stellar object, calculates the ideal $delta to satisfy the 
     * fuzzy conditions.
     * 
     * @var float
     */
    public protected(set) float $delta = 0.25 {
        get { return $this->delta; }
        set(float $value) { $this->delta = abs($value); }
    }

    /**
     * Angular distance delta: It is used for an error biased search. 
     *
     * @var Angle $delta
     */
    public Angle $angular_delta {
        get { return Angle::createFromDecimal($this->delta); }
    }

    /**
     * Find an exact record.
     *
     * @return mixed
     */
    abstract public function found();
}