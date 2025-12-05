<?php
namespace MarcoConsiglio\Ephemeris\Records\Moon;

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
     * The current Moon latitude. It represents the
     * Moon position.
     * 
     * @var Angle
     */
    public protected(set) Angle $moon_latitude;

    /**
     * The current node longitude returned by the ephemeris.
     * It represent the position of one of the two nodes.
     * 
     * The swiss ephemeris returns only one of the two nodes.
     * This is the one returned by the swiss ephemeris.
     * 
     * @var Angle
     */
    public protected(set) Angle $node_longitude;

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
    public protected(set) Angle $opposite_node_longitude;

    /**
     * True if this is a north node, false otherwise.
     *
     * @var boolean|null
     */
    protected bool|null $is_north_node = null;

    /**
     * It constructs the Moon DraconicRecord. 
     *
     * @param SwissEphemerisDateTime $timestamp
     * @param Angle $moon_longitude
     * @param Angle $node_longitude
     * @param Angle $node_declination
     * @param float $moon_daily_speed
     * @param bool $is_north_node
     */
    public function __construct(
        SwissEphemerisDateTime $timestamp,
        Angle $moon_longitude,
        Angle $moon_latitude,
        Angle $node_longitude,
        Angle $opposite_node_longitude,
        float $moon_daily_speed
    ) {
        $this->timestamp = $timestamp;
        $this->moon_longitude = $moon_longitude;
        $this->moon_latitude = $moon_latitude;
        $this->node_longitude = $node_longitude;
        $this->opposite_node_longitude = $opposite_node_longitude;
        $this->daily_speed = $moon_daily_speed;
    }

    /**
     * It returns true if this record is a north node.
     *
     * @return boolean
     */
    public function isNorthNode(): bool
    {
        return $this->is_north_node;
    }

    /**
     * It returns true if this record is a south node.
     *
     * @return boolean
     */
    public function isSouthNode(): bool
    {
        return ! $this->isNorthNode();
    }

    /**
     * It sets the node cardinality (north or south),
     * if it is not setted yet.
     *
     * @param boolean $is_north_node True for a north node, false otherwise.
     * @return void
     */
    public function setNodeCardinality(bool $is_north_node)
    {
        if ($this->is_north_node !== null )
            $this->is_north_node = $is_north_node;
    }

}