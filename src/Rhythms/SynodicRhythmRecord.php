<?php
namespace MarcoConsiglio\Ephemeris\Rhythms;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPeriodType;
use MarcoConsiglio\Ephemeris\SwissDateTime;
use MarcoConsiglio\Trigonometry\Angle;

/**
 * A single snapshot of the Moon synodic rhythm.
 * @property-read \MarcoConsiglio\Ephemeris\SwissDateTime $timestamp The timestamp of this record.
 * @property-read \MarcoConsiglio\Trigonometry\Angle $angular_distance Angular distance percentage.
 * @property-read float $percentage The angular distance percentage.
 */
class SynodicRhythmRecord
{
    /**
     * The timestamp of this record.
     *
     * @var \Carbon\Carbon
     */
    protected SwissDateTime $timestamp;

    /**
     * The angular distance between the Moon and the Sun.
     *
     * @var \MarcoConsiglio\Trigonometry\Angle
     */
    protected Angle $angular_distance;

    /**
     * Angular distance percentage.
     *
     * @var float
     */
    protected float $percentage;

    /**
     * Instantiate a SynodicRhythmRecord from Swiss Ephemeris.
     *
     * @param string $timestamp The string timestamp must match one of the following patterns:
     * SwissDateTime::GREGORIAN_UT, SwissDateTime::GREGORIAN_TT, SwissDateTime::JULIAN_UT, SwissDateTime::JULIAN_TT.
     * @param float $angular_distance
     */
    public function __construct(string $timestamp, float $angular_distance)
    {
        if (is_string($timestamp)) {
            $formats = [
                SwissDateTime::GREGORIAN_UT,
                SwissDateTime::GREGORIAN_TT,
                SwissDateTime::JULIAN_UT,
                SwissDateTime::JULIAN_TT
            ];
            foreach ($formats as $format) {
                if (SwissDateTime::canBeCreatedFromFormat($timestamp, $format)) {
                    $this->timestamp = SwissDateTime::rawCreateFromFormat($format, $timestamp);
                }
            }
        }
        $this->angular_distance = Angle::createFromDecimal($angular_distance);
        $this->percentage = round($this->angular_distance->toDecimal() / 180, 2);
    }

    /**
     * Getters.
     *
     * @param string $name The property name.
     * @return void
     */
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }

    /**
     * Check if this record refers to a waxing moon period.
     *
     * @return boolean
     */
    public function isWaxing()
    {
        if ($this->angular_distance->isClockwise()) {
            return true;
        }
        return false;
    }

    /**
     * Check if this record refers to a waning moon period.
     *
     * @return boolean
     */
    public function isWaning()
    {
        if ($this->angular_distance->isCounterClockwise()) {
            return true;
        }
        return false;
    }

    /**
     * Get the type of the Moon period in this SynodicRhythmRecord.
     *
     * @return \MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPeriodType
     */
    public function getType(): MoonPeriodType
    {
        return $this->isWaxing() ? MoonPeriodType::Waxing : MoonPeriodType::Waning;
    }

    /**
     * Check if this record is equal to another.
     *
     * @param SynodicRhythmRecord $object
     * @return boolean
     */
    public function equals(SynodicRhythmRecord $object): bool
    {
        $a = $object->timestamp === $this->timestamp;
        $b = $object->angular_distance === $this->angular_distance;
        $c = $object->percentage === $this->percentage;
        return $a && $b && $c; 
    }
}