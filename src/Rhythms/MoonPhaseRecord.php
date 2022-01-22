<?php
namespace MarcoConsiglio\Ephemeris\Rhythms;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType;

/**
 * A Moon phase in a precise timestamp.
 * @property-read \Carbon\Carbon $timestamp
 * @property-read \MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType $type
 */
class MoonPhaseRecord
{
    /**
     * The timestamp this record refers to.
     *
     * @var \Carbon\Carbon
     */
    protected Carbon $timestamp;

    /**
     * The type of this moon phase.
     *
     * @var \MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType
     */
    protected MoonPhaseType $type;

    /**
     * Constructs a MoonPhaseRecord with a moon phase type and a timestamp.
     *
     * @param Carbon        $timestamp
     * @param MoonPhaseType $type
     */
    public function __construct(Carbon $timestamp, MoonPhaseType $type)
    {
        $this->timestamp = $timestamp;
        $this->type = $type;
    }

    /**
     * Getters.
     *
     * @param string $property
     * @return mixed
     */
    public function __get(string $property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
}