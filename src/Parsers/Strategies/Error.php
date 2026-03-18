<?php
namespace MarcoConsiglio\Ephemeris\Parsers\Strategies;

use MarcoConsiglio\Ephemeris\Enums\RegExPattern;

/**
 * The parsing strategy used to find an error
 * in the raw Swiss Ephemeris output.
 */
class Error extends ParsingStrategy
{
    /**
     * Find an error row in the raw Swiss Ephemeris output.
     */
    public function found(): ?string
    {
        if (preg_match(RegExPattern::SwetestError->value, $this->text, $error_match) == 1) {
            return trim($error_match[1]);
        } else return null;    
    }
}