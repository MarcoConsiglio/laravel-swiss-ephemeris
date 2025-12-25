<?php
namespace MarcoConsiglio\Ephemeris\Records\Moon;

use MarcoConsiglio\Ephemeris\Enums\Moon\Phase;
use MarcoConsiglio\Ephemeris\Records\Record;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;

/**
 * It represents a time when the Moon 
 * is in a specific lunar phase.
 */
class PhaseRecord extends Record
{
    /**
     * The phase of the Moon it refers to.
     *
     * @var Phase $type
     */
    public protected(set) Phase $type;

    /**
     * Construct a MoonPhaseRecord with a moon phase type and a timestamp.
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
     * Pack the object properties in an associative array.
     * 
     * @return array{phase:mixed,timestamp:string}
     */
    protected function packProperties(): array
    {
        return [
            "timestamp" => $this->timestamp->toDateTimeString(),
            "phase" => $this->enumToString($this->type)
        ];
    }

    /**
     * Get the parent properties packed in an associative 
     * array.
     * 
     * @return array
     * @codeCoverageIgnore
     */
    #[\Override]
    protected function getParentProperties(): array {return [];}
}