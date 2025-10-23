<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces;

/**
 * The behaviour of a rhythm builder.
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