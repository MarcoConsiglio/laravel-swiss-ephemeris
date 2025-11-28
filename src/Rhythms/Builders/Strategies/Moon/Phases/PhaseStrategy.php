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
     * The angular neighborhood within which to accept a record.
     *
     * @var float
     */
    public protected(set) float $delta;

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
        $this->delta = $this->calculateDelta();
    }

    /**
     * It returns the daily speed of the SynodicRhythmRecord
     * the strategy uses.
     *
     * @return float
     */
    protected function getSpeed(): float
    {
        return $this->record->daily_speed;
    }
}