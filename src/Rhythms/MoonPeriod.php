<?php
namespace MarcoConsiglio\Ephemeris\Rhythms;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPeriodType;

/**
 * A Waxing or Waning Moon period.
 * 
 * @property-read \Carbon\Carbon $start The period start.
 * @property-read \Carbon\Carbon $end The period end.
 * @property-read \MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPeriodType $type The period type, waxing or waning.
 */
class MoonPeriod
{
    /**
     * Start timestamp of this period.
     *
     * @var \Carbon\Carbon
     */
    protected Carbon $start;

    /**
     * End timestamp of this period.
     *
     * @var \Carbon\Carbon
     */
    protected Carbon $end;

    /**
     * The type of this period (waning or waxing).
     *
     * @var \MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPeriodType
     */
    protected MoonPeriodType $type;

    /**
     * Constructs a MoonPeriod.
     *
     * @param \Carbon\Carbon                                         $start
     * @param \Carbon\Carbon                                         $end
     * @param \MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPeriodType $type
     */
    public function __construct(Carbon $start, Carbon $end, MoonPeriodType $type)
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
        return $this->type == MoonPeriodType::Waxing;
    }

    /**
     * Tells if this period is waning.
     *
     * @return boolean
     */
    public function isWaning()
    {
        return $this->type == MoonPeriodType::Waning;
    }

    /**
     * Getters.
     *
     * @param string $property
     * @return void
     */
    public function __get(string $property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

}