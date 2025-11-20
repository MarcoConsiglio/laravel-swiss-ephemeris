<?php
namespace MarcoConsiglio\Ephemeris\Records\Moon;

use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Goniometry\Angle;

/**
 * It represents a moment when the moon 
 * passes over the point of intersection 
 * between its orbit and the plane of 
 * the ecliptic.
 */
class DraconicRecord
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
     * The current Moon latitude. It represents the
     * Moon position.
     * 
     * @var Angle
     */
    public protected(set) Angle $moon_latitude;

    /**
     * The current node longitude. It represents the
     * node position.
     * 
     * @var Angle
     */
    public protected(set) Angle $node_longitude;

    /**
     * It constructs the Moon DraconicRecord. 
     *
     * @param SwissEphemerisDateTime $timestamp
     * @param Angle $moon_longitude
     * @param Angle $node_longitude
     * @param Angle $node_declination
     */
    public function __construct(
        SwissEphemerisDateTime $timestamp,
        Angle $moon_longitude,
        Angle $moon_latitude,
        Angle $node_longitude,
    ) {
        $this->timestamp = $timestamp;
        $this->moon_longitude = $moon_longitude;
        $this->moon_latitude = $moon_latitude;
        $this->node_longitude = $node_longitude;
    }

    /**
     * It returns true if this record is a north node.
     *
     * @return boolean
     */
    public function isNorthNode(): bool
    {
        // This is a serious problem.
        return false;
    }

    /**
     * It returns true if this record is a south node.
     *
     * @return boolean
     */
    public function isSouthNode(): bool
    {
        // This is a serious problem. 
        return false;
    }
}