<?php
namespace MarcoConsiglio\Ephemeris\Rhythms;

use Illuminate\Support\Collection;
use Iterator;

/**
 * A collection of MoonPeriod(s).
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
        if (isset($this->items[$key])) {
            return $this->items[$key];
        }
        return null;
    }
}