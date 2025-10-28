<?php
namespace MarcoConsiglio\Ephemeris\Parsers\Strategies;

use MarcoConsiglio\Ephemeris\Enums\RegExPattern;

/**
 * The ParsingStrategy used to find a warning
 * in the raw Swiss Ephemeris output.
 */
class Warning extends ParsingStrategy
{
    /**
     * Find an warning row in the raw swiss ephemeris output.
     *
     * @return string|null
     */
    public function found(): ?string
    {
        if (preg_match(
            RegExPattern::SwetestWarning->value.RegExPattern::SingleLine, 
            $this->text, $warning_match) == 1) 
        return trim($warning_match[1]); 
        else return null;
    }
}