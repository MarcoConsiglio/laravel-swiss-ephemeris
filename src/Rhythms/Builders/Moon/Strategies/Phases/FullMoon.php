<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Phases;

use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;

/**
 * The strategy used to find a Moon SynodicRhythmRecord 
 * matching the full Moon phase.
 */
class FullMoon extends PhaseStrategy
{
    /**
     * Return the record only if its angular_distance is about +/-180°.
     */
    public function found(): ?SynodicRhythmRecord
    {
        if ($this->isAbout($this->record->angular_distance->toDecimal(), -180, $this->calculateDelta())) {
            return $this->record;
        }
        if ($this->isAbout($this->record->angular_distance->toDecimal(), 180, $this->calculateDelta())) {
            return $this->record;
        }
        return null;
    }
}