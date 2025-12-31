<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Moon;

use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Perigees\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Perigees\FromRecords;

/**
 * A collection of Moon PerigeeRecord instances.
 * 
 * Represents a collection of record where the Moon
 * is in its perigee.
 */
class Perigees extends Collection
{
    /**
     * Construct a Moon Perigees collection from an array of raw ephemeris.
     */
    public function __construct(FromArray|FromRecords $builder)
    {
        $this->items = $builder->fetchCollection();
    }

    /**
     * Get the first Moon PerigeeRecord.
     *
     * @param mixed $default
     */
    #[\Override]
    public function first(?callable $callback = null, $default = null): PerigeeRecord
    {
        return parent::first($callback, $default);
    }

    /**
     * Get the last Moon PerigeeRecord.
     *
     * @param mixed $default
     */
    #[\Override]
    public function last(?callable $callback = null, $default = null): PerigeeRecord
    {
        return parent::last($callback, $default);
    }

    /**
     * Get an Moon PerigeeRecord from the collection by key.
     *
     * @param mixed $key
     * @param mixed $default
     */
    #[\Override]
    public function get($key, $default = null): PerigeeRecord
    {
        return parent::get($key, $default);
    }
}