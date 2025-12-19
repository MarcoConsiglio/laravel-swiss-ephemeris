<?php
namespace MarcoConsiglio\Ephemeris\Records\Moon;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Ephemeris\Records\MovingObjectRecord;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;

/**
 * It represents an instant when the Moon 
 * is at either apogee or perigee.
 */
abstract class AnomalisticRecord extends MovingObjectRecord
{
    /**
     * The timestamp of this Moon AnomalistcRecord.
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

    /**
     * Pack the object properties in an associative array.
     * 
     * @return array{moon_longitude:string,timestamp:string}
     */

    /**
     * Pack the object properties in an associative array.
     * 
     * @return array{moon_longitude:string,timestamp:string}
     */
    protected function packProperties(): array
    {
        return array_merge(self::getParentProperties(), [
            "timestamp" => $this->timestamp->toDateTimeString(),
            "moon_longitude" => "{$this->moon_longitude->toDecimal()}°"
        ]);
    }

    /**
     * Get the parent properties packed in an associative 
     * array.
     * 
     * @return array{daily_speed:string}
     */
    protected function getParentProperties(): array
    {
        return parent::packProperties();
    }
}