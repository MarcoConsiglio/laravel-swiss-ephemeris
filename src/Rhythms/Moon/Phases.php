<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Moon;

use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Records\Moon\PhaseRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\Phases\FromSynodicRhythm;

/**
 * A collection of Moon PhaseRecord instances.
 * 
 * It represents a collection of records of the 
 * Moon's synodic rhythm that represents the lunar phases.
 */
class Phases extends Collection
{
    /**
     * Construct a Phase collection from a SynodicRhythm collection.
     *
     * @param FromSynodicRhythm $builder
     */
    public function __construct(FromSynodicRhythm $builder)
    {
        $this->items = $builder->fetchCollection();
    }

    /**
     * Get a Moon PhaseRecord from the collection by key.
     *
     * @param mixed $key
     * @param mixed $default
     * @return PhaseRecord
     */
    public function get($key, $default = null): PhaseRecord
    {
        return parent::get($key, $default);
    }

    /**
     * Get the first Moon PhaseRecord.
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return PhaseRecord
     */
    public function first(?callable $callback = null, $default = null): PhaseRecord
    {
        return parent::first($callback, $default);
    }

    /**
     * Get the last Moon PhaseRecord.
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return PhaseRecord
     */
    public function last(?callable $callback = null, $default = null): PhaseRecord
    {
        return parent::last($callback, $default);
    }
}