<?php
namespace MarcoConsiglio\Ephemeris\Parsers\Strategies;

/**
 * The behaviour of a raw swiss ephemeris output parsing strategy.
 */
interface Strategy
{
    /**
     * Find an exact row in the raw swiss ephemeris output.
     *
     * @return mixed
     */
    public function found();
}