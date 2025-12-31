<?php
namespace MarcoConsiglio\Ephemeris\Parsers\Strategies\Moon;

use MarcoConsiglio\Ephemeris\Parsers\Strategies\ParsingStrategy;

/**
 * The `ParsingStrategy` to find `SynodicRhythmRecord` data.
 */
class SynodicRecord extends ParsingStrategy
{
    /**
     * Find a data line in the raw swiss ephemeris output.
     */
    public function found(): array
    {
        $this->split($this->text);
        $this->trim();
        return $this->data;
    }
}