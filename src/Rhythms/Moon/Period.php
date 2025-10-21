<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Moon;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Enums\Moon\Period as PeriodType;

/**
 * Represents a fraction of the Moon phase cicle, 
 * i.e. waxing or waning Moon period.
 * 
 * @property-read \Carbon\Carbon $start The period start.
 * @property-read \Carbon\Carbon $end The period end.
 * @property-read Period $type The period type, waxing or waning.
 */
class Period
{
    /**
     * Start timestamp of this period.
     *
     * @var \Carbon\Carbon
     */
    public protected(set) Carbon $start;

    /**
     * End timestamp of this period.
     *
     * @var \Carbon\Carbon
     */
    public protected(set) Carbon $end;

    /**
     * The type of this period (waning or waxing).
     *
     * @var PeriodType
     */
    public protected(set) PeriodType $type;

    /**
     * Constructs a Moon period.
     *
     * @param \Carbon\Carbon                                         $start
     * @param \Carbon\Carbon                                         $end
     * @param PeriodType $type
     */
    public function __construct(Carbon $start, Carbon $end, PeriodType $type)
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
    public function isWaxing()
    {
        return $this->type == PeriodType::Waxing;
    }

    /**
     * Tells if this period is waning.
     *
     * @return boolean
     */
    public function isWaning()
    {
        return $this->type == PeriodType::Waning;
    }
}