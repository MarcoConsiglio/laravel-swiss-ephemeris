<?php
namespace MarcoConsiglio\Ephemeris\Records\Moon;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use MarcoConsiglio\Ephemeris\Enums\Moon\Phase;

/**
 * A Moon phase in a precise timestamp.
 * @property-read \Carbon\Carbon $timestamp
 * @property-read \MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType $type
 */
class PhaseRecord
{
    /**
     * The timestamp this record refers to.
     *
     * @var \Carbon\CarbonInterface
     */
    public protected(set) CarbonInterface $timestamp;

    /**
     * The phase of the Moon it refers to.
     *
     * @var Phase $type
     */
    public protected(set) Phase $type;

    /**
     * Constructs a MoonPhaseRecord with a moon phase type and a timestamp.
     *
     * @param \Carbon\CarbonInterface        $timestamp
     * @param MoonPhaseType $type
     */
    public function __construct(CarbonInterface $timestamp, Phase $type)
    {
        $this->timestamp = $timestamp;
        $this->type = $type;
    }
}