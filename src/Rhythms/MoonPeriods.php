<?php
namespace MarcoConsiglio\Ephemeris\Rhythms;

use Illuminate\Support\Collection;
use Iterator;

/**
 * A collection of lunar periods relative to the Sun over a period of time.
 */
class MoonPeriods extends Collection
{
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