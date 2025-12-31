<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Moon;

use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromRecords;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\Periods\FromSynodicRhythm as MoonPeriodBuilder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\Phases\FromSynodicRhythm as MoonPhasesBuilder;

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
     * The sampling rate of the ephemeris expressed in minutes 
     * per each step of the ephemeris response.
     * 
     * @var int
     */
    public protected(set) int $sampling_rate;

    /**
     * Construct a Moon SynodicRhythm.
     *
     * @param FromArray|FromRecords $items
     * @param int $sampling_rate The sampling rate of the ephemeris 
     * expressed in minutes per each step of the ephemeris response.
     */
    public function __construct(FromArray|FromRecords $builder, int $sampling_rate)
    {
        $this->items = $builder->fetchCollection(); 
        $this->sampling_rate = $sampling_rate;
    }

    /**
     * Get a Moon SynodicRhythmRecord from the collection by key.
     *
     * @param  mixed  $key
     * @param  mixed  $default
     */
    #[\Override]
    public function get($key, $default = null): SynodicRhythmRecord
    {
        return parent::get($key, $default = null);
    }

    /**
     * Get a collection of Moon Periods.
     */
    public function getPeriods(): Periods
    {
        return new Periods(new MoonPeriodBuilder($this));
    }

    /**
     * Get a collection of Moon Phases.
     *
     * @param array $moon_phase_types An array of Moon PhaseType
     * items representing which lunar phases you want to extract.
     */
    public function getPhases(array $moon_phase_types): Phases
    {
        return new Phases(new MoonPhasesBuilder($this, $moon_phase_types, $this->sampling_rate));
    }

    /**
     * Get the first Moon SynodicRhythmRecord.
     *
     * @param mixed $default
     */
    #[\Override]
    public function first(?callable $callback = null, $default = null): SynodicRhythmRecord
    {
        return parent::first($callback, $default);
    }

    /**
     * Get the last Moon SynodicRhythmRecord.
     *
     * @param mixed        $default
     */
    #[\Override]
    public function last(?callable $callback = null, $default = null): SynodicRhythmRecord
    {
        return parent::last($callback, $default);
    }
}