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
    public protected(set) Carbon $timestamp;

    /**
     * The type of this moon phase.
     *
     * @var \MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType
     */
    public protected(set) MoonPhaseType $type;

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
}