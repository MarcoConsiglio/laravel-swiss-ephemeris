<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Moon;

use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Phases\FromSynodicRhythm;

/**
 * A collection of Moon PhaseRecord instances.
 */
class Phases extends Collection
{
    /**
     * Constructs a Phase collection from a SynodicRhythm collection.
     *
     * @param FromSynodicRhythm $builder
     */
    public function __construct(FromSynodicRhythm $builder)
    {
        $this->items = $builder->fetchCollection();
    }
}