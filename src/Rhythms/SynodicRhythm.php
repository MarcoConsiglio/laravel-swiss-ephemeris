<?php
namespace MarcoConsiglio\Ephemeris\Rhythms;

use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPeriods\FromSynodicRhythm as MoonPeriodBuilder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\FromSynodicRhythm as MoonPhasesBuilder;
use MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType;

/**
 * Represents the rhythm of the Moon over a period of time.
 */
class SynodicRhythm extends Collection
{
    /**
     * Create a new SynodicRhythm.
     *
     * @param mixed $items
     */
    public function __construct($items = [])
    {
        if (empty($items)) {
            throw new InvalidArgumentException("The SynodicRhythm must be constructed with SynodicRhythmRecord(s) or an array with 'timestamp' and 'angular_distance' setted.");
        }
        $this->items = $items;
    }

    /**
     * Gets a SynodicRhythmRecord from the collection by key.
     *
     * @param  mixed  $key
     * @param  mixed  $default
     * @return \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord
     */
    public function get($key, $default = null): SynodicRhythmRecord
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
     * Gets the first SynodicRhythmRecord.
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord
     */
    public function first(?callable $callback = null, $default = null): SynodicRhythmRecord
    {
        return parent::first($callback, $default);
    }

    /**
     * Gets the last SynodicRhythmRecord.
     *
     * @param callable|null $callback
     * @param mixed        $default
     * @return \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord
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