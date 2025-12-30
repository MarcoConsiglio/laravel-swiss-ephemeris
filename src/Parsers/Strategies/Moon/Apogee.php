<?php
namespace MarcoConsiglio\Ephemeris\Parsers\Strategies\Moon;

use MarcoConsiglio\Ephemeris\Enums\RegExPattern;
use MarcoConsiglio\Ephemeris\Parsers\Strategies\ParsingStrategy;

/**
 * The ParsingStrategy used to parse an Apogee from
 * raw ephemeris data.
 */
class Apogee extends ParsingStrategy
{
    /**
     * Find a data line in the raw swiss ephemeris output.
     *
     * @return array
     */
    public function found(): array
    {
        $this->split($this->text);
        $this->trim();
        return $this->data;
    }
}