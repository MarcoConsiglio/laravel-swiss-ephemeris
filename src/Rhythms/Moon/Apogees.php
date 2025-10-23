<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Moon;

use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Apogees\FromArray;

/**
 * A collection of Moon Apogee instances.
 */
class Apogees extends Collection
{
    public function __construct(FromArray $builder)
    {
        $this->items = $builder->fetchCollection();
    }
}