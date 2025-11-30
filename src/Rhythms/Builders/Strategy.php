<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Traits\WithFuzzyLogic;
use MarcoConsiglio\Goniometry\Angle;
use RoundingMode;

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
     * @var float
     */
    public protected(set) float $delta;

    /**
     * Angular distance delta: It is used for an error biased search. 
     *
     * @var Angle $delta
     */
    public Angle $angular_delta {
        get { return Angle::createFromDecimal($this->delta); }
    }

    /**
     * The sampling rate of the ephemeris expressed in minutes.
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
     * It calculates the delta angle used to select/discard a record based on the 
     * record daily speed and the ephemeris sampling rate.
     * 
     * This roughly means that the delta will have a sampling rate twice the 
     * ephemeris sampling rate, to ensure that the correct records are selected/discarded.
     *
     * @return float
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
     * It returns the daily speed of the record the strategy uses.
     *
     * @return float
     */
    abstract protected function getSpeed(): float;
}