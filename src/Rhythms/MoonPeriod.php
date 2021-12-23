<?php
namespace MarcoConsiglio\Ephemeris\Rhythms;

use Carbon\Carbon;

class MoonPeriod
{
    /**
     * It refers to the waxing moon period.
     */
    public const WAXING = 0;

    /**
     * It refers to the waning moon period.
     */
    public const WANING = 1;

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
     * @var integer
     */
    private int $type;

    /**
     * Constructs a MoonPeriod.
     *
     * @param Carbon  $start
     * @param Carbon  $end
     * @param integer $type The type of the period: waning or waxing.
     */
    public function __construct(Carbon $start, Carbon $end, int $type)
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
        return $this->type == self::WAXING;
    }

    /**
     * Tells if this period is waning.
     *
     * @return boolean
     */
    public function isWaning()
    {
        return $this->type == self::WANING;
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