<?php
namespace MarcoConsiglio\Ephemeris\Rhythms;

use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;

/**
 * A collection of MoonPhaseRecord(s) over a period of time.
 */
class MoonPhases extends Collection
{
    public function __construct(Builder $builder)
    {
        $this->items = $builder->fetchCollection();
    }
}