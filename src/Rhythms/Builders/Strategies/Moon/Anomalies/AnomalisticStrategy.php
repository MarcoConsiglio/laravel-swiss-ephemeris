<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Anomalies;

use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Strategy;
use MarcoConsiglio\Goniometry\Angle;

/**
 * Describes a strategy used to found a record of the Moon anomalistic rhythm.
 */
abstract class AnomalisticStrategy extends Strategy
{

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
     * @var float $delta
     */
    public protected(set) float $delta = 0.5 {
        get { return $this->delta; }
        set(float $value) { $this->delta = abs($value); }
    }

    /**
     * The record to analize.
     *
     * @var ApogeeRecord|PerigeeRecord
     */
    protected ApogeeRecord|PerigeeRecord $record;
    


    /**
     * Find an exact record.
     *
     * @return mixed
     */
    abstract public function found();
}