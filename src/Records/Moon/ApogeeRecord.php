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
     * The current Moon apogee longitude. It represents
     * the apogee position.
     */
    public protected(set) Angle $apogee_longitude;

    /**
     * It constructs a Moon ApogeeRecord.
     * 
     * It can be that $moon_longitude and $apogee_longitute are not close enough
     * to be considered a Moon apogee. In order to have real apogees you should
     * instantiate a Moon Apogees collection.
     *
     * @param SwissEphemerisDateTime $timestamp
     * @param Angle $moon_longitude
     * @param Angle $apogee_longitude
     * @param float $moon_daily_speed The daily speed of the Moon expressed in
     * decimal degrees.
     */
    public function __construct(SwissEphemerisDateTime $timestamp, Angle $moon_longitude, Angle $apogee_longitude, float $moon_daily_speed)
    {
        $this->timestamp = $timestamp;
        $this->moon_longitude = $moon_longitude;
        $this->apogee_longitude = $apogee_longitude;
        $this->daily_speed = $moon_daily_speed;
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
        $d = $this->daily_speed == $another_record->daily_speed;
        return $a && $b && $c && $d;
    }

    /**
     * It cast this record to string.
     *
     * @return string
     */
    public function __toString()
    {
        return <<<TEXT
timestamp: {$this->timestamp->toGregorianTT()}
moon_longitude: {$this->moon_longitude->toDecimal()}°
apogee_longitude: {$this->apogee_longitude->toDecimal()}°
daily_speed: {$this->daily_speed}°/day
TEXT;
    }
}