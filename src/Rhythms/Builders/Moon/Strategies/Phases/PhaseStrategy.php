<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Phases;

use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategy;

/**
 * The strategy used to find a Moon phase.
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
     * Construct a FirstQuarter strategy with a Moon SynodicRhythmRecord.
     *
     * @param SynodicRhythmRecord $record
     * @param int $sampling_rate The sampling rate of the ephemeris 
     * expressed in minutes per each step of the ephemeris response.
     */
    public function __construct(SynodicRhythmRecord $record, int $sampling_rate)
    {
        $this->record = $record;
        $this->sampling_rate = $sampling_rate;
        $this->delta = $this->calculateDelta();
    }

    /**
     * Return the daily speed of the record the strategy uses.
     *
     * @return float
     */
    protected function getSpeed(): float
    {
        return $this->record->daily_speed;
    }
}