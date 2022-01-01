<?php
namespace MarcoConsiglio\Ephemeris\Rhythms;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPeriodType;
use MarcoConsiglio\Trigonometry\Angle;

/**
 * A single snapshot of the Moon synodic rhythm.
 * @property-read \Carbon\Carbon $timestamp
 * @property-read \MarcoConsiglio\Trigonometry\Angle $angular_distance
 * @property-read float $percentage Angular distance percentage.
 */
class SynodicRhythmRecord
{
    /**
     * Timestamp of this record.
     *
     * @var Carbon
     */
    protected Carbon $timestamp;

    /**
     * Angular distance.
     *
     * @var Angle
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
     * @param string|\Carbon\Carbon $timestamp The string timestamp must match the pattern "d.m.Y H:m:i UT".
     * @param float $angular_distance
     */
    public function __construct(string|Carbon $timestamp, float $angular_distance)
    {
        if (is_string($timestamp)) {
            $this->timestamp = Carbon::createFromFormat(
                "d.m.Y H:m:i", 
                trim(str_replace("UT", "", $timestamp))
            );
        }
        if ($timestamp instanceof Carbon) {
            $this->timestamp = $timestamp;
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