<?php
namespace MarcoConsiglio\Ephemeris\Parsers\Strategies;

use MarcoConsiglio\Ephemeris\Enums\RegExPattern;

/**
 * It represents the parsing strategy of the raw Swiss Ephemeris output.
 */
abstract class ParsingStrategy implements Strategy
{
    /**
     * The text to be examined.
     *
     * @var string
     */
    protected string $text;

    /**
     * Construct the Error ParsingStrategy
     * with the $text to be examined.
     *
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->text = $text;
    }

    /**
     * Parse a datetime.
     *
     * @param string $text
     * @param mixed $match
     * @return integer|false
     */
    protected function datetimeFound(string $text, &$match): int|false
    {
        return preg_match(RegExPattern::UniversalAndTerrestrialDateTime->value, $text, $match);
    }

    /**
     * Parse a decimal number.
     *
     * @param string $text
     * @param mixed $match
     * @return integer|false
     */
    protected function decimalNumberFound(string $text, &$match): int|false
    {
        $result = preg_match_all(RegExPattern::RelativeDecimalNumber->value, $text, $match); 
        $match = $match[0];
        return $result;
    }

    /**
     * Parse an astral object name.
     *
     * @param string $text
     * @param string $regex
     * @param mixed $match
     * @return integer|false
     */
    protected function astralObjectFound(string $text, string $regex, &$match): int|false
    {
        return preg_match($regex, $text, $match);       
    }
} 