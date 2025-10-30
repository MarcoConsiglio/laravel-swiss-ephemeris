<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces;

/**
 * The behaviour of a rhythm builder.
 * 
 * It constructs a collection from diverse type of inputs.
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