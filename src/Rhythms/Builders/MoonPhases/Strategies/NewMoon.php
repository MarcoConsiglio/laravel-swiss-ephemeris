<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Traits\WithFuzzyCondition;

/**
 * Check if a MoonSynodicRhythmRecord is a new moon phase.
 */
class NewMoon extends MoonPhaseStrategy
{
    use WithFuzzyCondition;

    /**
     * The record to inspect.
     *
     * @var \MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythmRecord
     */
    protected MoonSynodicRhythmRecord $record;
    
    /**
     * Constructs a NewMoon strategy with a MoonSynodicRhythmRecord.
     *
     * @param \MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythmRecord $record
     */
    public function __construct(MoonSynodicRhythmRecord $record)
    {
        $this->record = $record;
    }

    /**
     * Return the record only if its angular_distance is about 0°.
     *
     * @return \MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythmRecord|null
     */
    public function found(): ?MoonSynodicRhythmRecord
    {   
        if ($this->isAbout($this->record->angular_distance->toDecimal(), 0, $this->getDelta())) {
            return $this->record;
        }
        return null;
    }
}