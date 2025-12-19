<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Moon;

use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Apogees\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Apogees\FromRecords;

/**
 * A collection of Moon ApogeeRecord instances.
 * 
 * It represents a collection of record where the Moon
 * is in its apogee.
 */
class Apogees extends Collection
{
    /**
     * Construct a Moon Apogees collection from an array of raw ephemeris.
     *
     * @param FromArray|FromRecords $builder
     */
    public function __construct(FromArray|FromRecords $builder)
    {
        $this->items = $builder->fetchCollection();
    }

    /**
     * Get the first Moon ApogeeRecord.
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return ApogeeRecord
     */
    public function first(?callable $callback = null, $default = null): ApogeeRecord
    {
        return parent::first($callback, $default);
    }

    /**
     * Get the last Moon ApogeeRecord.
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return ApogeeRecord
     */
    public function last(?callable $callback = null, $default = null): ApogeeRecord
    {
        return parent::last($callback, $default);
    }

    /**
     * Get an Moon ApogeeRecord from the collection by key.
     *
     * @param mixed $key
     * @param mixed $default
     * @return ApogeeRecord
     */
    public function get($key, $default = null): ApogeeRecord
    {
        return parent::get($key, $default);
    }
}