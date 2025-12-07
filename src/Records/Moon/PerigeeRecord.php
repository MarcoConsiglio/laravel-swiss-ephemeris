<?php
namespace MarcoConsiglio\Ephemeris\Records\Moon;

use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Goniometry\Interfaces\Angle;

/**
 * It represents a moment when the Moon is at its perigee.
 */
class PerigeeRecord extends AnomalisticRecord
{
    /**
     * The current Moon apogee longitude. It represents
     * the perigee position.
     */
    public protected(set) Angle $perigee_longitude;

    /**
     * Construct a Moon PerigeeRecord.
     * 
     * It can be that $moon_longitude and $apogee_longitute are not close enough
     * to be considered a Moon perigee. In order to have real perigee you should
     * instantiate a Moon Perigees collection.
     *
     * @param SwissEphemerisDateTime $timestamp
     * @param Angle $moon_longitude
     * @param Angle $apogee_longitude
     */
    public function __construct(SwissEphemerisDateTime $timestamp, Angle $moon_longitude, Angle $apogee_longitude, float $moon_daily_speed)
    {
        $this->timestamp = $timestamp;
        $this->moon_longitude = $moon_longitude;
        $this->perigee_longitude = $apogee_longitude;
        $this->daily_speed = $moon_daily_speed;
    }

    /**
     * Check if this record is equal to $another_record.
     *
     * @param PerigeeRecord $another_record
     * @return boolean
     */
    public function equals(PerigeeRecord $another_record): bool
    {
        $a = $this->timestamp == $another_record->timestamp;
        $b = $this->moon_longitude == $another_record->moon_longitude;
        $c = $this->perigee_longitude == $another_record->perigee_longitude;
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
Moon PerigeeRecord
timestamp: {$this->timestamp->toDateTimeString()}
moon_longitude: {$this->moon_longitude->toDecimal()}°
perigee_longitude: {$this->perigee_longitude->toDecimal()}°
daily_speed: {$this->daily_speed}°/day
TEXT;
    }
}