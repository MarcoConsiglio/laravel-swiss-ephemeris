<?php
namespace MarcoConsiglio\Ephemeris\Records\Moon;

use MarcoConsiglio\Ephemeris\Enums\Moon\Period;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Goniometry\Angle;
use RoundingMode;

/**
 * A single snapshot of the Moon synodic rhythm.
 * @property-read \MarcoConsiglio\Ephemeris\SwissEphemerisDateTime $timestamp The timestamp of this record.
 * @property-read \MarcoConsiglio\Goniometry\Angle $angular_distance Angular distance percentage.
 * @property-read int $percentage The angular distance percentage.
 */
class SynodicRhythmRecord
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
    public protected(set) int|float $percentage {
        get => (int) round($this->percentage * 100, 0, RoundingMode::HalfTowardsZero);
        set => $this->percentage = $value;
    }

    /**
     * Instantiate a MoonSynodicRhythmRecord from Swiss Ephemeris.
     *
     * @param string $timestamp The string timestamp must match one of the following patterns:
     * SwissEphemerisDateTime::GREGORIAN_UT, SwissEphemerisDateTime::GREGORIAN_TT, 
     * SwissEphemerisDateTime::JULIAN_UT, SwissEphemerisDateTime::JULIAN_TT.
     * @param float $angular_distance The angular distance between Sun and Moon.
     */
    public function __construct(string $timestamp, float $angular_distance)
    {
        foreach (SwissEphemerisDateTime::availableFormats() as $format) {
            if (SwissEphemerisDateTime::canBeCreatedFromFormat($timestamp, $format)) {
                $this->timestamp = SwissEphemerisDateTime::rawCreateFromFormat($format, $timestamp);
            }
        }
        $this->angular_distance = Angle::createFromDecimal($angular_distance);
        $this->percentage = round(
            $this->angular_distance->toDecimal() / 180, 2, 
            RoundingMode::HalfTowardsZero
        );
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