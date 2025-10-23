<?php
namespace MarcoConsiglio\Ephemeris\Records\Moon;

use Carbon\CarbonInterface;
use MarcoConsiglio\Ephemeris\Enums\Moon\Period as PeriodType;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;

/**
 * Represents a fraction of the Moon phase cicle, 
 * i.e. a waxing or a waning Moon period.
 * 
 * @property-read SwissEphemerisDateTime $start The period start.
 * @property-read SwissEphemerisDateTime $end The period end.
 * @property-read Period $type The period type, waxing or waning.
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
     * Constructs a Moon period.
     *
     * @param CarbonInterface $start
     * @param CarbonInterface $end
     * @param PeriodType $type
     */
    public function __construct(CarbonInterface $start, CarbonInterface $end, PeriodType $type)
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