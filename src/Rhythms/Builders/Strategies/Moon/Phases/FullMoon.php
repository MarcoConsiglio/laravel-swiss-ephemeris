<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases;

use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Traits\WithFuzzyCondition;

/**
 * The strategy is used to find a Moon SynodicRhythmRecord 
 * matching the full Moon phase.
 */
class FullMoon extends PhaseStrategy
{
    /**
     * Construct a FullMoon strategy with a MoonSynodicRhythmRecord.
     *
     * @param SynodicRhythmRecord $record
     */
    public function __construct(SynodicRhythmRecord $record)
    {
        $this->record = $record;
    }

    /**
     * Return the record only if its angular_distance is about +/-180°.
     *
     * @return SynodicRhythmRecord|null
     */
    public function found(): ?SynodicRhythmRecord
    {
        if ($this->isAbout($this->record->angular_distance->toDecimal(), -180, $this->delta)) {
            return $this->record;
        }
        if ($this->isAbout($this->record->angular_distance->toDecimal(), 180, $this->delta)) {
            return $this->record;
        }
        return null;
    }

    /**
     * Gets the delta specified by the strategy.
     *
     * @return float
     */
    public function getDelta(): float
    {
        return $this->delta;
    }
}