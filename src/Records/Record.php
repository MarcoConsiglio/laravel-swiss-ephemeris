<?php
namespace MarcoConsiglio\Ephemeris\Records;

use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Traits\StringableRecord;
use Stringable;

/**
 * It defines the abstract concept of a record of the 
 * ephemeris.
 * 
 * @codeCoverageIgnore
 */
abstract class Record implements Stringable
{
    use StringableRecord;

    /**
     * The timestamp of this `Record`.
     */
    public protected(set) SwissEphemerisDateTime $timestamp;

    /**
     * Get the parent properties packed in an associative
     * array.
     */
    protected function getParentProperties(): array
    {
        return [];
    }
}