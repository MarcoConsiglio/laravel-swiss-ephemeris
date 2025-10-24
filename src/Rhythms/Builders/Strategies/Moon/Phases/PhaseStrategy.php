<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases;

use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Strategy;

/**
 * Describe a strategy used to find a Moon phase.
 * 
 * @property-read float $delta Angular distance delta: It is used for an error biased search. 
 */
abstract class PhaseStrategy extends Strategy
{
    /**
     * The record to inspect.
     *
     * @var SynodicRhythmRecord
     */
    protected SynodicRhythmRecord $record;

    /**
     * Find an exact record.
     *
     * @return mixed
     */
    public abstract function found();
}