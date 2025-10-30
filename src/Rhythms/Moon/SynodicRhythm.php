<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Moon;

use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Periods\FromSynodicRhythm as MoonPeriodBuilder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Phases\FromSynodicRhythm as MoonPhasesBuilder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromRecords;

/**
 * A collection of Moon SynodicRhythmRecord instances.
 * 
 * Represents the Moon's synodic rhythm over a time range. 
 * A Moon synodic rhythm, or synodic period, is the time it takes 
 * for a celestial object to return to the same position 
 * relative to the Sun, as seen from the Earth.
 */
class SynodicRhythm extends Collection
{
    /**
     * Constructs a Moon SynodicRhythm.
     *
     * @param FromArray|FromRecords $items
     */
    public function __construct(FromArray|FromRecords $builder)
    {
        $this->items = $builder->fetchCollection(); 
    }

    /**
     * Gets a Moon SynodicRhythmRecord from the collection by key.
     *
     * @param  mixed  $key
     * @param  mixed  $default
     * @return SynodicRhythmRecord
     */
    public function get($key, $default = null): SynodicRhythmRecord
    {
        return parent::get($key, $default = null);
    }

    /**
     * Gets a collection of Moon Periods.
     *
     * @return Periods
     */
    public function getPeriods(): Periods
    {
        return new Periods(new MoonPeriodBuilder($this));
    }

    /**
     * Gets a collection of Moon Phases.
     *
     * @param array $moon_phase_types An array ofMoonPhaseType
     * items representing which moon phases you want to extract.
     * @return Phases
     */
    public function getPhases(array $moon_phase_types): Phases
    {
        return new Phases(new MoonPhasesBuilder($this, $moon_phase_types));
    }

    /**
     * Gets the first Moon SynodicRhythmRecord.
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return SynodicRhythmRecord
     */
    public function first(?callable $callback = null, $default = null): SynodicRhythmRecord
    {
        return parent::first($callback, $default);
    }

    /**
     * Gets the last Moon SynodicRhythmRecord.
     *
     * @param callable|null $callback
     * @param mixed        $default
     * @return SynodicRhythmRecord
     */
    public function last(?callable $callback = null, $default = null): SynodicRhythmRecord
    {
        return parent::last($callback, $default);
    }
}