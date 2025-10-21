<?php
namespace MarcoConsiglio\Ephemeris\Records\Moon;

use Carbon\CarbonInterface;

/**
 * It represents an instant when the Moon is at either apogee or perigee.
 */
abstract class AnomalisticRecord
{
    /**
     * The timestamp of this MoonAnomalistcRecord.
     */
    public protected(set) CarbonInterface $timestamp;
}