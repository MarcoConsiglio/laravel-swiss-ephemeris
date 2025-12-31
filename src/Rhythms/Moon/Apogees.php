<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Moon;

use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Apogees\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Apogees\FromRecords;

/**
 * A collection of Moon ApogeeRecord instances.
 * 
 * Represents a collection of record where the Moon
 * is in its apogee.
 */
class Apogees extends Collection
{
    /**
     * Construct a Moon Apogees collection from an array of raw ephemeris.
     */
    public function __construct(FromArray|FromRecords $builder)
    {
        $this->items = $builder->fetchCollection();
    }

    /**
     * Get the first Moon ApogeeRecord.
     *
     * @param mixed $default
     */
    #[\Override]
    public function first(?callable $callback = null, $default = null): ApogeeRecord
    {
        return parent::first($callback, $default);
    }

    /**
     * Get the last Moon ApogeeRecord.
     *
     * @param mixed $default
     */
    #[\Override]
    public function last(?callable $callback = null, $default = null): ApogeeRecord
    {
        return parent::last($callback, $default);
    }

    /**
     * Get an Moon ApogeeRecord from the collection by key.
     *
     * @param mixed $key
     * @param mixed $default
     */
    #[\Override]
    public function get($key, $default = null): ApogeeRecord
    {
        return parent::get($key, $default);
    }
}