<?php
namespace MarcoConsiglio\Ephemeris\Parsers\Strategies\Moon;

use MarcoConsiglio\Ephemeris\Enums\RegExPattern;
use MarcoConsiglio\Ephemeris\Parsers\Strategies\ParsingStrategy;

class Perigee extends ParsingStrategy
{
    /**
     * Find a data line in the raw swiss ephemeris output.
     *
     * @return mixed
     */
    public function found(): array
    {
        $this->split($this->text);
        $this->trim();
        return $this->data;
    }
}