<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Moon;

use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\DraconicRhythm\FromArray;

/**
 * A collection of DraconicRecord instances.
 */
class DraconicRhythm extends Collection
{
    /**
     * Constructs a Moon DraconicRhythm collection.
     */
    public function __construct(FromArray $builder)
    {
        $this->items = $builder->fetchCollection();
    }

    /**
     * Get the first Moon DraconicRecord.
     *
     * @param mixed $default
     */
    #[\Override]
    public function first(?callable $callback = null, $default = null): DraconicRecord
    {
        return parent::first($callback, $default);
    }

    /**
     * Get the last Moon DraconicRecord.
     *
     * @param mixed $default
     */
    #[\Override]
    public function last(?callable $callback = null, $default = null): DraconicRecord
    {
        return parent::last($callback, $default);
    }

    /**
     * Get an Moon DraconicRecord from the collection by key.
     *
     * @param mixed $key
     * @param mixed $default
     */
    #[\Override]
    public function get($key, $default = null): DraconicRecord
    {
        return parent::get($key, $default);
    }
}