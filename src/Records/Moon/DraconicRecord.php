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
     * The current node longitude. It represents the
     * node position.
     * 
     * @var Angle
     */
    public protected(set) Angle $node_longitude;

    /**
     * The current node declination. It represents the
     * node position above or under the ecliptic plane.
     * 
     * @var Angle
     */
    public protected(set) Angle $node_declination;

    /**
     * It construct the Moon DraconicRecord. 
     *
     * @param SwissEphemerisDateTime $timestamp
     * @param Angle $moon_longitude
     * @param Angle $node_longitude
     * @param Angle $node_declination
     */
    public function __construct(
        SwissEphemerisDateTime $timestamp,
        Angle $moon_longitude,
        Angle $node_longitude,
        Angle $node_declination
    ) {
        $this->timestamp = $timestamp;
        $this->moon_longitude = $moon_longitude;
        $this->node_longitude = $node_longitude;
        $this->node_declination = $node_declination;
    }

    /**
     * It returns true if this record is a north node.
     *
     * @return boolean
     */
    public function isNorthNode(): bool
    {
        return $this->node_declination->gte(Angle::createFromValues(0));
    }

    /**
     * It returns true if this record is a south node.
     *
     * @return boolean
     */
    public function isSouthNode(): bool
    {
        return $this->node_declination->isLessThan(Angle::createFromDecimal(0));
    }
}