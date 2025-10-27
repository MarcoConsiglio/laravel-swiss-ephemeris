<?php
namespace MarcoConsiglio\Ephemeris\Records\Moon;

use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;

/**
 * It represents an instant when the Moon is at either apogee or perigee.
 */
abstract class AnomalisticRecord
{
    /**
     * The timestamp of this MoonAnomalistcRecord.
     */
    public protected(set) SwissEphemerisDateTime $timestamp;
}