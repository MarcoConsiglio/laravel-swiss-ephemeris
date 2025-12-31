<?php
namespace MarcoConsiglio\Ephemeris\Parsers\Strategies;

use MarcoConsiglio\Ephemeris\Enums\RegExPattern;

/**
 * The parsing strategy used to find a warning
 * in the raw Swiss Ephemeris output.
 */
class Warning extends ParsingStrategy
{
    /**
     * Find an warning row in the raw swiss ephemeris output.
     */
    public function found(): ?string
    {
        if (preg_match(
            RegExPattern::SwetestWarning->value, 
            $this->text, $warning_match) == 1) 
        return trim($warning_match[1]); 
        else return null;
    }
}