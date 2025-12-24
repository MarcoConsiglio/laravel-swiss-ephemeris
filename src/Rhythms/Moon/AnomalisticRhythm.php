<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Moon;

use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Records\Moon\AnomalisticRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\FromCollections;

/**
 * A collection of Moon AnomalisticRecord instances.
 * 
 * It represents a collection of records in which the 
 * Moon passes over its node, that is, the 
 * intersection of the Moon's orbit on the plane of 
 * the ecliptic.
 */
class AnomalisticRhythm extends Collection
{
    /**
     * Construct the collection starting from
     * Moon Apogees and Moon Perigees collections.
     *
     * @param FromCollections $builder
     */
    public function __construct(FromCollections $builder)
    {
        $this->items = $builder->fetchCollection();
    }

    /**
     * Get the first Moon AnomalisticRecord.
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return AnomalisticRecord
     */
    #[\Override]
    public function first(?callable $callback = null, $default = null): AnomalisticRecord
    {
        return parent::first($callback, $default);
    }

    /**
     * Get the last Moon AnomalisticRecord.
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return AnomalisticRecord
     */
    #[\Override]
    public function last(?callable $callback = null, $default = null): AnomalisticRecord
    {
        return parent::last($callback, $default);
    }

    /**
     * Get an Moon AnomalisticRecord from the collection by key.
     *
     * @param mixed $key
     * @param mixed $default
     * @return AnomalisticRecord
     */
    #[\Override]
    public function get($key, $default = null): AnomalisticRecord
    {
        return parent::get($key, $default);
    }
}