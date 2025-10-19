<?php
namespace MarcoConsiglio\Ephemeris\Command;

use AdamBrett\ShellWrapper\Command\Flag;

/**
 * Represent a flag for the Swiss Ephemeris executable.
 */
class SwissEphemerisFlag extends Flag
{
    /**
     * Cast the Flag to a string.
     *
     * @return string
     */
    protected function getValuesAsString(): string
    {
        // $values = array_map('escapeshellarg', $this->values);
        $prefix = sprintf('%s%s', static::PREFIX, $this->name);
        return $prefix . join("", $this->values);
    }
}