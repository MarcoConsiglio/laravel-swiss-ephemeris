<?php
namespace MarcoConsiglio\Ephemeris\Parsers\Strategies;

use MarcoConsiglio\Ephemeris\Enums\RegExPattern;

/**
 * The parsing strategy used to find a "using" notice
 * in the raw Swiss Ephemeris output.
 */
class Using extends ParsingStrategy
{
    /**
     * Find a "using" notice row in the raw Swiss Ephemeris output.
     *
     * @return ?string
     */
    public function found(): ?string
    {
        if (preg_match(RegExPattern::SwetestUsing->value, $this->text, $error_match) == 1) {
            return trim($error_match[0]);
        } else return null;    
    }
}