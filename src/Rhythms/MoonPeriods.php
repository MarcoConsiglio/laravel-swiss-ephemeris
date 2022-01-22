<?php
namespace MarcoConsiglio\Ephemeris\Rhythms;

use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;

/**
 * A collection of lunar periods of the Moon synodic Rhythm.
 */
class MoonPeriods extends Collection
{
    /**
     * Constructs the builder with an array of MoonPeriod instances.
     *
     * @param mixed $items
     */
    public function __construct($items = [])
    {
        $this->items = $this->getArrayableItems($items);
    }

    /**
     * Gets a MoonPeriod from the collection by key.
     *
     * @param  mixed  $key
     * @return \MarcoConsiglio\Ephemeris\Rhythms\MoonPeriod
     */
    public function get($key, $default = null): ?MoonPeriod
    {
        return parent::get($key, $default);
    }
}