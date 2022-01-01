<?php
namespace MarcoConsiglio\Ephemeris\Rhythms;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPeriodType;

/**
 * A waxing or waning moon period.
 * @property-read \Carbon\Carbon $start
 * @property-read \Carbon\Carbon $end
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
     * @param Carbon  $start
     * @param Carbon  $end
     * @param integer $type The type of the period: waning or waxing.
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