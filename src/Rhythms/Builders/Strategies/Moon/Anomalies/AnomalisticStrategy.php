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
     * Angular distance delta: It is used for an error biased search. 
     *
     * @var float $delta
     */
    public protected(set) float $delta = 0.36 {
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