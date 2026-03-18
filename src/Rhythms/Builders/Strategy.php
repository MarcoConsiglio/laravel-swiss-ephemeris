<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders;

use RoundingMode;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Traits\WithFuzzyLogic;

/**
 * The abstract Strategy used to build a rhythm.
 * 
 * Implemented in a concrete Strategy defines the algorithm
 * used to choose which record would be part of the rhythm,
 * and which not.
 * 
 */
abstract class Strategy implements BuilderStrategy
{
    use WithFuzzyLogic;

    /**
     * Angular value expressed as a decimal number: It 
     * is used for an error biased search. 
     * 
     * @var float
     */
    public protected(set) float $delta;

    /**
     * Angular distance delta: It is used for an error 
     * biased search. 
     *
     * @var Angle $delta
     */
    public Angle $angular_delta {
        get { return Angle::createFromDecimal($this->delta); }
    }

    /**
     * The sampling rate of the ephemeris expressed in minutes 
     * per each step of the ephemeris response.
     *
     * @var integer
     */
    protected int $sampling_rate;

    /**
     * Find an exact record.
     *
     * @return mixed
     */
    abstract public function found();

    /**
     * Calculate the delta angle used to select/discard a record based on the
     * record daily speed and the ephemeris sampling rate.
     *
     * This roughly means that the delta will have a sampling rate twice the
     * ephemeris sampling rate, to ensure that the correct records are selected/discarded.
     *
     * Two variables are required to calculate the delta that allow to sample an ephemeris
     * value at roughly two times the ephemeris sampling rate:
     * - the stellar object daily speed (degrees/day),
     * - the sampling rate of the ephemeris requested (minutes between each step of the
     * ephemeris response).
     */
    protected function calculateDelta(): float
    {
        return round(
            $this->getSpeed() * $this->sampling_rate / 1440 /* minutes */,
            PHP_FLOAT_DIG,
            RoundingMode::HalfTowardsZero
        );
    }

    /**
     * Return the daily speed of the record the strategy uses.
     */
    abstract protected function getSpeed(): float;
}