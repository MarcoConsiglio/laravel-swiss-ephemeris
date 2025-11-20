<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases;

use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Strategy;

/**
 * Describe a strategy used to find a Moon phase.
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
     * The sampling rate of the ephemeris expressed in minutes.
     *
     * @var integer
     */
    protected int $sampling_rate;

    /**
     * It constructs a FirstQuarter strategy with a Moon SynodicRhythmRecord.
     *
     * @param SynodicRhythmRecord $record
     * @param int $sampling_rate The sampling rate of the ephemeris expressed in minutes.
     */
    public function __construct(SynodicRhythmRecord $record, int $sampling_rate)
    {
        $this->record = $record;
        $this->sampling_rate = $sampling_rate;
    }

    /**
     * Find an exact record.
     *
     * @return mixed
     */
    public abstract function found();

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
        return ($this->record->daily_speed / (1440 /* minutes */ / $this->sampling_rate)) / 2;
    }
}