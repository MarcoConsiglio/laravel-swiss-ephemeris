<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces;

/**
 * The behavior of a strategy used to select the correct records
 * in order to build a rhythm.
 */
interface BuilderStrategy
{
    /**
     * Find an exact record.
     *
     * @return mixed
     */
    public function found();
}