<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\MoonPhaseStrategy;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Traits\WithFuzzyCondition;

/**
 * This strategy is used to find a Moon SynodicRhythmRecord matching
 * the third quarter Moon phase.
 */
class ThirdQuarter extends PhaseStrategy
{
    /**
     * Constructs a ThirdQuarter strategy with a MoonSynodicRhythmRecord.
     *
     * @param SynodicRhythmRecord $record
     */
    public function __construct(SynodicRhythmRecord $record)
    {
        $this->record = $record;
    }

    /**
     * Return the record only if its angular_distance is about -90°.
     *
     * @return SynodicRhythmRecord|null
     */
    public function found(): ?SynodicRhythmRecord
    {
        if ($this->isAbout($this->record->angular_distance->toDecimal(), -90, $this->delta)) {
            return $this->record;
        }
        return null;
    }
}