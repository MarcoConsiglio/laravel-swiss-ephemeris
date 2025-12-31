<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces;

/**
 * The behaviour of a Rhythm Builder which constructs a collection from diverse
 * type of inputs.
 */
interface Builder
{
    /**
     * Fetch the builded collection.
     *
     * @return mixed
     */
    public function fetchCollection();
}