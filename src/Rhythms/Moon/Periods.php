<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Moon;

use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Records\Moon\Period;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\Periods\FromSynodicRhythm;

/**
 * A collection of Moon Period instances.
 * 
 * It represents a collection of time periods between
 * a lunar phase and another.
 */
class Periods extends Collection
{
    /**
     * Construct a Periods collection from a SynodicRhythm collection.
     *
     * @param FromSynodicRhythm $builder
     */
    public function __construct(FromSynodicRhythm $builder)
    {
        $this->items = $builder->fetchCollection();
    }

    /**
     * Get the first Moon Period.
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return Period
     */
    #[\Override]
    public function first(?callable $callback = null, $default = null): Period
    {
        return parent::first($callback, $default);
    }

    /**
     * Get the last Moon Period.
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return Period
     */
    #[\Override]
    public function last(?callable $callback = null, $default = null): Period
    {
        return parent::last($callback, $default); 
    }

    /**
     * Get a Moon Period from the collection by key.
     *
     * @param mixed $key
     * @param mixed $default
     * @return Period
     */
    #[\Override]
    public function get($key, $default = null): Period
    {
        return parent::get($key, $default);
    }
}