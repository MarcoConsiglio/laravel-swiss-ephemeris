<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Traits\WithFuzzyCondition;

/**
 * Check if a SynodicRhythmRecord is a third quarter moon phase.
 */
class ThirdQuarter extends MoonPhaseStrategy
{
    use WithFuzzyCondition;

    /**
     * The record to inspect.
     *
     * @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord
     */
    protected SynodicRhythmRecord $record;

    /**
     * Constructs a ThirdQuarter strategy with a SynodicRhythmRecord.
     *
     * @param \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $record
     */
    public function __construct(SynodicRhythmRecord $record)
    {
        $this->record = $record;
    }

    /**
     * Return the record only if its angular_distance is about -90°.
     *
     * @return \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord|null
     */
    public function findRecord(): ?SynodicRhythmRecord
    {
        if ($this->isAbout($this->record->angular_distance->toDecimal(), -90, $this->getDelta())) {
            return $this->record;
        }
        return null;
    }
}