<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Moon;

use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\FromCollections;
use MarcoConsiglio\Ephemeris\Records\Moon\AnomalisticRecord;

/**
 * A collection of Moon AnomalisticRecord instances.
 */
class AnomalisticRhythm extends Collection
{
    /**
     * Constructs the collection starting from
     * Moon Apogees and Moon Perigees collections.
     *
     * @param FromCollections $builder
     */
    public function __construct(FromCollections $builder)
    {
        $this->items = $builder->fetchCollection();
    }

    /**
     * Gets the first Moon AnomalisticRecord.
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return AnomalisticRecord
     */
    public function first(?callable $callback = null, $default = null): AnomalisticRecord
    {
        return parent::first($callback, $default);
    }

    /**
     * Gets the last Moon AnomalisticRecord.
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return AnomalisticRecord
     */
    public function last(?callable $callback = null, $default = null): AnomalisticRecord
    {
        return parent::last($callback, $default);
    }

    /**
     * Gets an Moon AnomalisticRecord from the collection by key.
     *
     * @param mixed $key
     * @param mixed $default
     * @return AnomalisticRecord
     */
    public function get($key, $default = null): AnomalisticRecord
    {
        return parent::get($key, $default);
    }
}