<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Moon;

use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Records\Moon\Period;
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

    /**
     * Gets the first Moon Period.
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return Period
     */
    public function first(?callable $callback = null, $default = null): Period
    {
        return parent::first($callback, $default);
    }

    /**
     * Gets the last Moon Period.
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return Period
     */
    public function last(?callable $callback = null, $default = null): Period
    {
        return parent::last($callback, $default); 
    }

    /**
     * Gets a Moon Period from the collection by key.
     *
     * @param [type] $key
     * @param [type] $default
     * @return Period
     */
    public function get($key, $default = null): Period
    {
        return parent::get($key, $default);
    }
}