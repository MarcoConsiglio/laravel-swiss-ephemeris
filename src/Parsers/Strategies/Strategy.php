<?php
namespace MarcoConsiglio\Ephemeris\Parsers\Strategies;

/**
 * The behaviour of a raw Swiss Ephemeris output parsing strategy.
 */
interface Strategy
{
    /**
     * Find a data line in the raw swiss ephemeris output.
     *
     * @return mixed
     */
    public function found();
}