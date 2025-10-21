<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases;

use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\MoonPhaseStrategy;
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
     * @var SynodicRhythmRecord
     */
    protected SynodicRhythmRecord $record;
    
    /**
     * Constructs a NewMoon strategy with a MoonSynodicRhythmRecord.
     *
     * @param SynodicRhythmRecord $record
     */
    public function __construct(SynodicRhythmRecord $record)
    {
        $this->record = $record;
    }

    /**
     * Return the record only if its angular_distance is about 0°.
     *
     * @return SynodicRhythmRecord|null
     */
    public function found(): ?SynodicRhythmRecord
    {   
        if ($this->isAbout($this->record->angular_distance->toDecimal(), 0, $this->getDelta())) {
            return $this->record;
        }
        return null;
    }
}