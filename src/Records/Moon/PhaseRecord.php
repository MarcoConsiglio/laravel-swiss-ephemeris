<?php
namespace MarcoConsiglio\Ephemeris\Records\Moon;

use MarcoConsiglio\Ephemeris\Enums\Moon\Phase;
use MarcoConsiglio\Ephemeris\Records\Record;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;

/**
 * It represents a time when the Moon 
 * is in a specific lunar phase.
 */
class PhaseRecord
{
    /**
     * The timestamp this record refers to.
     *
     * @var SwissEphemerisDateTime
     */
    public protected(set) SwissEphemerisDateTime $timestamp;

    /**
     * The phase of the Moon it refers to.
     *
     * @var Phase $type
     */
    public protected(set) Phase $type;

    /**
     * It constructs a MoonPhaseRecord with a moon phase type and a timestamp.
     *
     * @param SwissEphemerisDateTime        $timestamp
     * @param Phase $type
     */
    public function __construct(SwissEphemerisDateTime $timestamp, Phase $type)
    {
        $this->timestamp = $timestamp;
        $this->type = $type;
    }

    /**
     * It cast this record to string.
     *
     * @return string
     */
    public function __toString()
    {
        $type = ((array) $this->type)["name"];
        return <<<TEXT
Moon PhaseRecord
timestamp: {$this->timestamp->toDateTimeString()}
phase: {$type}
TEXT;
    }
}