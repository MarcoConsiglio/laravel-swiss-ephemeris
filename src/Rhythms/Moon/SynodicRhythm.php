<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Moon;

use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Periods\FromSynodicRhythm as MoonPeriodBuilder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Phases\FromSynodicRhythm as MoonPhasesBuilder;

/**
 * Represents the Moon's Synodic Rhythm over a time range.
 * A Moon synodic rhythm, or synodic period, is the time it takes 
 * for a celestial object to return to the same position 
 * relative to the Sun, as seen from Earth.
 */
class SynodicRhythm extends Collection
{
    /**
     * Create a new MoonSynodicRhythm.
     *
     * @param mixed $items
     */
    public function __construct($items = [])
    {
        if (empty($items)) {
            throw new InvalidArgumentException("The MoonSynodicRhythm must be constructed with MoonSynodicRhythmRecord(s) or an array with 'timestamp' and 'angular_distance' setted.");
        }
        $this->items = $items;
    }

    /**
     * Gets a MoonSynodicRhythmRecord from the collection by key.
     *
     * @param  mixed  $key
     * @param  mixed  $default
     * @return \MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythmRecord
     */
    public function get($key, $default = null): SynodicRhythmRecord
    {
        return parent::get($key, $default = null);
    }

    /**
     * Gets a collection of MoonPeriods.
     *
     * @return Periods
     */
    public function getPeriods(): Periods
    {
        $builder = new MoonPeriodBuilder($this);
        return new Periods($builder->fetchCollection());
    }

    /**
     * Gets a collection of MoonPhases.
     *
     * @param array $moon_phase_types An array ofMoonPhaseType
     * items representing which moon phases you want to extract.
     * @return Phases
     */
    public function getPhases(array $moon_phase_types): Phases
    {
        $builder = new MoonPhasesBuilder($this, $moon_phase_types);
        return new Phases($builder->fetchCollection());
    }

    /**
     * Gets the first MoonSynodicRhythmRecord.
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
     * Gets the last MoonSynodicRhythmRecord.
     *
     * @param callable|null $callback
     * @param mixed        $default
     * @return SynodicRhythmRecord
     */
    public function last(?callable $callback = null, $default = null): SynodicRhythmRecord
    {
        if ($this->items instanceof LazyCollection) {
            /**
             * @var \Illuminate\Support\LazyCollection
             */
            $lazy_collection = $this->items;
            return $lazy_collection->last($callback, $default);
        }
        return parent::last($callback, $default);
    }
}