<?php
namespace MarcoConsiglio\Ephemeris\Records\Moon;

use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Goniometry\Interfaces\Angle;

/**
 * It represents a moment when the Moon is at its apogee.
 */
class ApogeeRecord extends AnomalisticRecord
{
    /**
     * The timestamp this record refers to.
     *
     * @var SwissEphemerisDateTime
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
     * The current Moon apogee longitude. It represents
     * the apogee position.
     */
    public protected(set) Angle $apogee_longitude;

    /**
     * Constructs a Moon ApogeeRecord.
     * 
     * It can be that $moon_longitude and $apogee_longitute are not close enough
     * to be considered a Moon apogee. In order to have real apogees you should
     * instantiate a Moon Apogees collection.
     *
     * @param SwissEphemerisDateTime $timestamp
     * @param Angle $moon_longitude
     * @param Angle $apogee_longitude
     */
    public function __construct(SwissEphemerisDateTime $timestamp, Angle $moon_longitude, Angle $apogee_longitude)
    {
        $this->timestamp = $timestamp;
        $this->moon_longitude = $moon_longitude;
        $this->apogee_longitude = $apogee_longitude;
    }

    /**
     * Check if this record is equal to $another_record.
     *
     * @param ApogeeRecord $another_record
     * @return boolean
     */
    public function equals(ApogeeRecord $another_record): bool
    {
        $a = $this->timestamp == $another_record->timestamp;
        $b = $this->moon_longitude == $another_record->moon_longitude;
        $c = $this->apogee_longitude == $another_record->apogee_longitude;
        return $a && $b && $c;
    }
}