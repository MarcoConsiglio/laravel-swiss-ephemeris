<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Moon;

use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Records\Moon\PhaseRecord;
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

    /**
     * Gets a Moon PhaseRecord from the collection by key.
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
     * Gets the first Moon PhaseRecord.
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
     * Gets the last Moon PhaseRecord.
     *
     * @param callable|null $callback
     * @param [type] $default
     * @return PhaseRecord
     */
    public function last(?callable $callback = null, $default = null): PhaseRecord
    {
        return parent::last($callback, $default);
    }
}