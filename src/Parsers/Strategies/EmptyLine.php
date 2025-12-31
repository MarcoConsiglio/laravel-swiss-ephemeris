<?php
namespace MarcoConsiglio\Ephemeris\Parsers\Strategies;

use MarcoConsiglio\Ephemeris\Enums\RegExPattern;

/**
 * The parsing strategy used to find an empty line
 * in the raw Swiss Ephemeris output.
 */
class EmptyLine extends ParsingStrategy
{
    /**
     * Find an empty line in the raw Swiss Ephemeris output.
     */
    public function found(): bool
    {
        if (preg_match(RegExPattern::EmptyLine->value, $this->text, $empty_line) == 1)
            return true;
        else
            return false;
    }
}