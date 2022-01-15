<?php
namespace MarcoConsiglio\Ephemeris\Rhythms;

use Illuminate\Support\Collection;
use Illuminate\Support\LazyCollection;
use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPeriods\FromSynodicRhythm;

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
        $builder = new FromSynodicRhythm($this);
        $builder->validateData();
        $builder->buildRecords();
        return new MoonPeriods($builder->fetchCollection());
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