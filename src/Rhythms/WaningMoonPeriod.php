<?php
namespace MarcoConsiglio\Ephemeris\Rhythms;

use Carbon\Carbon;

/**
 * Represents a waning moon period, that is a
 * phase of the moon synodic rhythm.
 * @property-read \Carbon\Carbon $start_timestamp
 * @property-read \Carbon\Carbon $end_timestamp
 */
class WaningMoonPeriod
{
    /**
     * Start of the waxing period.
     *
     * @var \Carbon\Carbon
     */
    protected Carbon $start_timestamp;

    /**
     * End of the waxing period.
     *
     * @var \Carbon\Carbon
     */
    protected Carbon $end_timestamp;

    public function __construct(Carbon $start, Carbon $end)
    {
        $this->start_timestamp = $start;
        $this->end_timestamp = $end;
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