<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces;

/**
 * The behavior of a strategy for rhythm builders.
 */
interface BuilderStrategy
{
    /**
     * Find an exact record.
     *
     * @return mixed
     */
    public function findRecord();
}