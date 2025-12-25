<?php
namespace MarcoConsiglio\Ephemeris\Records\Moon;

use RoundingMode;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Ephemeris\Enums\Moon\Period;
use MarcoConsiglio\Ephemeris\Records\MovingObjectRecord;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;

/**
 * It represent a moment of the Moon synodic rhythm.
 */
class SynodicRhythmRecord extends MovingObjectRecord
{
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
     * Construct a Moon SynodicRhythmRecord.
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
        return $this->angular_distance->isCounterClockwise();
    }

    /**
     * Check if this record refers to a waning moon period.
     *
     * @return boolean
     */
    public function isWaning(): bool
    {
        return $this->angular_distance->isClockwise();
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
     * Pack the object properties in an associative array.
     * 
     * @return array{angular_distance:string,daily_speed:string,period_type:string,phase_percentage:string,timestamp:string}
     */
    #[\Override]
    protected function packProperties(): array
    {
        return array_merge(self::getParentProperties(),  [
            "timestamp" => $this->timestamp->toDateTimeString(),
            "angular_distance" => "{$this->angular_distance->toDecimal()}°",
            "phase_percentage" => "{$this->percentage}%",
            "period_type" => $this->enumToString($this->getPeriodType()),
        ]);
    }

    /**
     * Get the parent properties packed in an associative 
     * array.
     * 
     * @return array{daily_speed:string}
     */
    #[\Override]
    protected function getParentProperties(): array
    {
        return parent::packProperties();
    }
}