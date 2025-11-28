<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases;

use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;

/**
 * This strategy is used to find a Moon SynodicRhythmRecord 
 * matching the new Moon phase.
 */
class NewMoon extends PhaseStrategy
{
    /**
     * Return the record only if its angular_distance is about 0°.
     *
     * @return SynodicRhythmRecord|null
     */
    public function found(): ?SynodicRhythmRecord
    {   
        if ($this->isAbout($this->record->angular_distance->toDecimal(), 0, $this->calculateDelta())) {
            return $this->record;
        }
        return null;
    }
}