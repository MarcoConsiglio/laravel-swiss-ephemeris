<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Moon;

use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Perigees\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Perigees\FromRecords;

/**
 * A collection of Moon ApogeeRecord instances.
 */
class Perigees extends Collection
{
    /**
     * Constructs a Moon Perigees collection from an array of raw ephemeris.
     *
     * @param FromArray|FromRecords $builder
     */
    public function __construct(FromArray|FromRecords $builder)
    {
        $this->items = $builder->fetchCollection();
    }

    /**
     * Gets the first Moon PerigeeRecord.
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return PerigeeRecord
     */
    public function first(?callable $callback = null, $default = null): PerigeeRecord
    {
        return parent::first($callback, $default);
    }

    /**
     * Gets the last Moon PerigeeRecord.
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return PerigeeRecord
     */
    public function last(?callable $callback = null, $default = null): PerigeeRecord
    {
        return parent::last($callback, $default);
    }

    /**
     * Gets an Moon PerigeeRecord from the collection by key.
     *
     * @param mixed $key
     * @param mixed $default
     * @return PerigeeRecord
     */
    public function get($key, $default = null): PerigeeRecord
    {
        return parent::get($key, $default);
    }
}