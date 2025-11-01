<?php
namespace MarcoConsiglio\Ephemeris\Records\Moon;

use MarcoConsiglio\Ephemeris\Enums\Moon\Period as PeriodType;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;

/**
 * Represents a fraction of the Moon phase cicle, 
 * i.e. a waxing or a waning Moon period.
 */
class Period
{
    /**
     * Start timestamp of this period.
     *
     * @var SwissEphemerisDateTime
     */
    public protected(set) SwissEphemerisDateTime $start;

    /**
     * End timestamp of this period.
     *
     * @var SwissEphemerisDateTime
     */
    public protected(set) SwissEphemerisDateTime $end;

    /**
     * The type of this period (waning or waxing).
     *
     * @var PeriodType
     */
    public protected(set) PeriodType $type;

    /**
     * It constructs a Moon period.
     *
     * @param SwissEphemerisDateTime $start
     * @param SwissEphemerisDateTime $end
     * @param PeriodType $type
     */
    public function __construct(SwissEphemerisDateTime $start, SwissEphemerisDateTime $end, PeriodType $type)
    {
        $this->start = $start;
        $this->end = $end;
        $this->type = $type;
    }

    /**
     * Tells if this period is waxing.
     *
     * @return boolean
     */
    public function isWaxing(): bool
    {
        return $this->type == PeriodType::Waxing;
    }

    /**
     * Tells if this period is waning.
     *
     * @return boolean
     */
    public function isWaning(): bool
    {
        return $this->type == PeriodType::Waning;
    }
}