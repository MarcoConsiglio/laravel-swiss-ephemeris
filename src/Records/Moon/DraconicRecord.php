<?php
namespace MarcoConsiglio\Ephemeris\Records\Moon;

use MarcoConsiglio\Ephemeris\Enums\Cardinality;
use MarcoConsiglio\Ephemeris\Records\Record;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Goniometry\Angle;

/**
 * It represents a moment when the moon 
 * passes over the point of intersection 
 * between its orbit and the plane of 
 * the ecliptic.
 */
class DraconicRecord extends Record
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
     * The current node longitude returned by the ephemeris.
     * It represent the position of one of the two nodes.
     * 
     * The swiss ephemeris returns only one of the two nodes.
     * This is the one returned by the swiss ephemeris.
     * 
     * @var Angle
     */
    public protected(set) Angle $north_node_longitude;

    /**
     * The current opposite node longitude. It represent the
     * position of one of the two nodes.
     * 
     * The swiss ephemeris returns only one of the two nodes.
     * This is the one opposite to the only node presents in
     * the ephemeris response.
     * 
     * @var Angle
     * @see Angle::$node_longitude
     */
    public protected(set) Angle $south_node_longitude;

    /**
     * True if this is a north node, false otherwise.
     *
     * @var Cardinality
     */
    public Cardinality|null $cardinality = null {
        set(Cardinality|null $cardinality) {
            if ($this->cardinality === null)
                $this->cardinality = $cardinality;
        }
    }

    /**
     * Construct the Moon DraconicRecord. 
     *
     * @param SwissEphemerisDateTime $timestamp
     * @param Angle $moon_longitude
     * @param Angle $north_node_longitude
     * @param float $moon_daily_speed
     */
    public function __construct(
        SwissEphemerisDateTime $timestamp,
        Angle $moon_longitude,
        Angle $north_node_longitude,
        float $moon_daily_speed
    ) {
        $this->timestamp = $timestamp;
        $this->moon_longitude = $moon_longitude;
        $this->north_node_longitude = $north_node_longitude;
        $this->south_node_longitude = $this->oppositeLongitude($north_node_longitude);
        $this->daily_speed = $moon_daily_speed;
    }

    /**
     * Calculate the opposite angle of a longitude value.
     *
     * @return Angle
     */
    protected function oppositeLongitude(Angle $longitude): Angle
    {
        $opposite = Angle::createFromValues(180, direction: Angle::CLOCKWISE);
        return Angle::sum($longitude, $opposite);
    }

    /**
     * Return true if this record is a north node.
     *
     * @return boolean
     */
    public function isNorthNode(): bool
    {
        return $this->cardinality == Cardinality::North;
    }

    /**
     * Return true if this record is a south node.
     *
     * @return boolean
     */
    public function isSouthNode(): bool
    {
        return $this->cardinality == Cardinality::South;
    }
}