<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Anomalies;

use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategy;

/**
 * Describes a strategy used to found a record of the Moon anomalistic rhythm.
 */
abstract class AnomalisticStrategy extends Strategy
{
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

    /**
     * It returns the daily speed of the AnomalisticRecord the strategy uses.
     *
     * @return float
     */
    protected function getSpeed(): float
    {
        return $this->record->daily_speed;
    }
}