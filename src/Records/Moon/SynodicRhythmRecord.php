<?php
namespace MarcoConsiglio\Ephemeris\Records\Moon;

use RoundingMode;
use MarcoConsiglio\Ephemeris\Enums\Moon\Period;
use MarcoConsiglio\Ephemeris\Records\Record;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Goniometry\Angle;

/**
 * It represent a moment of the Moon synodic rhythm.
 */
class SynodicRhythmRecord extends Record
{

    /**
     * The timestamp of this record.
     *
     * @var \MarcoConsiglio\Ephemeris\SwissEphemerisDateTime
     */
    public protected(set) SwissEphemerisDateTime $timestamp;

    /**
     * The angular distance between the Moon and the Sun.
     *
     * @var \MarcoConsiglio\Goniometry\Angle
     */
    public protected(set) Angle $angular_distance;

    /**
     * Angular distance percentage.
     *
     * @var int|float
     */
    public int|float $percentage {
        get => (int) round(
            $this->angular_distance->toDecimal() / 180 * 100, 
            0, RoundingMode::HalfTowardsZero
        );
    }

    /**
     * It constructs a Moon SynodicRhythmRecord.
     *
     * @param SwissEphemerisDateTime $timestamp
     * @param Angle $angular_distance The angular difference between the Moon and the Sun.
     * @param float $daily_speed The daily speed expressed in decimal degrees.
     */
    public function __construct(SwissEphemerisDateTime $timestamp, Angle $angular_distance, float $moon_daily_speed)
    {
        $this->timestamp = $timestamp;
        $this->angular_distance = $angular_distance;
        $this->daily_speed = $moon_daily_speed;
    }

    /**
     * Check if this record refers to a waxing moon period.
     *
     * @return boolean
     */
    public function isWaxing(): bool
    {
        if ($this->angular_distance->isCounterClockwise()) {
            return true;
        }
        return false;
    }

    /**
     * Check if this record refers to a waning moon period.
     *
     * @return boolean
     */
    public function isWaning(): bool
    {
        if ($this->angular_distance->isClockwise()) {
            return true;
        }
        return false;
    }

    /**
     * Get the type of the Moon period in this MoonSynodicRhythmRecord.
     *
     * @return Period
     */
    public function getPeriodType(): Period
    {
        return $this->isWaxing() ? Period::Waxing : Period::Waning;
    }

    /**
     * Check if this record is equal to $another_record.
     *
     * @param SynodicRhythmRecord $another_record
     * @return boolean
     */
    public function equals(SynodicRhythmRecord $another_record): bool
    {
        $a = $another_record->timestamp == $this->timestamp;
        $b = $another_record->angular_distance == $this->angular_distance;
        $c = $another_record->daily_speed == $this->daily_speed;
        return $a && $b && $c; 
    }

    /**
     * It cast this record to string.
     *
     * @return string
     */
    public function __toString()
    {
        $period = ((array) $this->getPeriodType())["name"];
        return <<<TEXT
Moon SynodicRhythmRecord
timestamp: {$this->timestamp->toDateTimeString()}
angular_distance: {$this->angular_distance->toDecimal()}°
phase_percentage: {$this->percentage}%
period_type: $period
daily_speed: {$this->daily_speed}°/day
TEXT;
    }
}