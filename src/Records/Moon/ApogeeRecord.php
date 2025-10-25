<?php
namespace MarcoConsiglio\Ephemeris\Records\Moon;

use Carbon\CarbonInterface;
use MarcoConsiglio\Goniometry\Interfaces\Angle;

/**
 * It represents a moment when the Moon is at its apogee.
 */
class ApogeeRecord extends AnomalisticRecord
{
    /**
     * The timestamp this record refers to.
     *
     * @var \Carbon\CarbonInterface
     */
    public protected(set) CarbonInterface $timestamp;

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
     * Constructs the record.
     *
     * @param CarbonInterface $timestamp The moment to which the record refers.
     */
    public function __construct(CarbonInterface $timestamp, Angle $moon_longitude, Angle $apogee_longitude)
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