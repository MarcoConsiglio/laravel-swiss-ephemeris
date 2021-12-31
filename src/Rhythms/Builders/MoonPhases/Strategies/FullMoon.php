<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Traits\WithFuzzyCondition;

class FullMoon implements BuilderStrategy
{
    use WithFuzzyCondition;

    /**
     * The record to inspect.
     *
     * @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord
     */
    protected SynodicRhythmRecord $record;

    /**
     * Construct a FullMoon strategy with a SynodicRhythmRecord.
     *
     * @param \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $record
     */
    public function __construct(SynodicRhythmRecord $record)
    {
        $this->record = $record;
    }

    /**
     * Return the record only if its angular_distance is about +/-180°.
     *
     * @return \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord|null
     */
    public function findRecord(): ?SynodicRhythmRecord
    {
        if ($this->isAbout($this->record->angular_distance->toDecimal(), -180)) {
            return $this->record;
        }
        if ($this->isAbout($this->record->angular_distance->toDecimal(), 180)) {
            return $this->record;
        }
        return null;
    }
}