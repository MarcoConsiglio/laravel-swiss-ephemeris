<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Moon;

use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Periods\FromSynodicRhythm;

/**
 * A collection of Moon Period instances.
 */
class Periods extends Collection
{
    /**
     * Constructs a Periods collection from a SynodicRhythm collection.
     *
     * @param FromSynodicRhythm $builder
     */
    public function __construct(FromSynodicRhythm $builder)
    {
        $this->items = $builder->fetchCollection();
    }
}