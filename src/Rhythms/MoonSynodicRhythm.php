<?php
namespace MarcoConsiglio\Ephemeris\Rhythms;

use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPeriods\FromMoonSynodicRhythm as MoonPeriodBuilder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\FromMoonSynodicRhythm as MoonPhasesBuilder;

/**
 * Represents the Moon's Synodic Rhythm over a time range.
 * A Moon synodic rhythm, or synodic period, is the time it takes 
 * for a celestial object to return to the same position 
 * relative to the Sun, as seen from Earth.
 */
class MoonSynodicRhythm extends Collection
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
    public function get($key, $default = null): MoonSynodicRhythmRecord
    {
        return parent::get($key, $default = null);
    }

    /**
     * Gets a collection of MoonPeriods.
     *
     * @return \MarcoConsiglio\Ephemeris\Rhythms\MoonPeriods
     */
    public function getPeriods(): MoonPeriods
    {
        $builder = new MoonPeriodBuilder($this);
        return new MoonPeriods($builder->fetchCollection());
    }

    /**
     * Gets a collection of MoonPhases.
     *
     * @param array $moon_phase_types An array ofMoonPhaseType
     * items representing which moon phases you want to extract.
     * @return \MarcoConsiglio\Ephemeris\Rhythms\MoonPhases
     */
    public function getPhases(array $moon_phase_types): MoonPhases
    {
        $builder = new MoonPhasesBuilder($this, $moon_phase_types);
        return new MoonPhases($builder->fetchCollection());
    }

    /**
     * Gets the first MoonSynodicRhythmRecord.
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return \MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythmRecord
     */
    public function first(?callable $callback = null, $default = null): MoonSynodicRhythmRecord
    {
        return parent::first($callback, $default);
    }

    /**
     * Gets the last MoonSynodicRhythmRecord.
     *
     * @param callable|null $callback
     * @param mixed        $default
     * @return \MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythmRecord
     */
    public function last(?callable $callback = null, $default = null): MoonSynodicRhythmRecord
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