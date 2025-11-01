<?php
namespace MarcoConsiglio\Ephemeris\Records\Moon;

use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Goniometry\Angle;

/**
 * It represents an instant when the Moon 
 * is at either apogee or perigee.
 */
abstract class AnomalisticRecord
{
    /**
     * The timestamp of this MoonAnomalistcRecord.
     */
    public protected(set) SwissEphemerisDateTime $timestamp;

    /**
     * The current Moon longitude. It represents the
     * Moon position.
     * 
     * @var Angle
     */
    public protected(set) Angle $moon_longitude;

    /**
     * Checks if this record is an Apogee.
     *
     * @return boolean
     */
    public function isApogee(): bool
    {
        return $this instanceof ApogeeRecord;
    }

    /**
     * Checks if this record is an Perigee.
     *
     * @return boolean
     */    
    public function isPerigee(): bool
    {
        return $this instanceof PerigeeRecord;
    }
}