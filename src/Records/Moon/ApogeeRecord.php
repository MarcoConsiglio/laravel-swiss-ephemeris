<?php
namespace MarcoConsiglio\Ephemeris\Records\Moon;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;

/**
 * Represents a moment when the Moon is at its apogee.
 */
class ApogeeRecord extends AnomalisticRecord
{
    /**
     * The current Moon apogee longitude. It represents
     * the apogee position.
     */
    public protected(set) Angle $apogee_longitude;

    /**
     * Construct a Moon ApogeeRecord.
     *
     * It can be that $moon_longitude and $apogee_longitute are not close enough
     * to be considered a Moon apogee. In order to have real apogees you should
     * instantiate a Moon Apogees collection.
     *
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
     * Pack the object properties in an associative array.
     * 
     * @return array{moon_longitude:string,timestamp:string,apogee_longitude:string,daily_speed:string}
     */
    #[\Override]
    protected function packProperties(): array
    {
        return array_merge(self::getParentProperties(), [
            "moon_longitude" => "{$this->moon_longitude->toDecimal()}°",
            "apogee_longitude" => "{$this->apogee_longitude->toDecimal()}°"
        ]);
    }

    /**
     * Get the parent properties packed in an associative 
     * array.
     * 
     * @return array{moon_longitude:string,timestamp:string}
     */
    #[\Override]
    protected function getParentProperties(): array
    {
        return parent::packProperties();
    }
}