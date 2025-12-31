<?php
namespace MarcoConsiglio\Ephemeris\Parsers\Strategies;

use Illuminate\Support\Facades\Config;
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
     * The variables inside $text, splitted
     * by its configured separator.
     * 
     * @var string[]
     */
    protected array $data = [];

    /**
     * Construct the Error ParsingStrategy
     * with the $text to be examined.
     */
    public function __construct(string $text)
    {
        $this->text = $text;
    }

    /**
     * Parse a datetime.
     *
     * @param mixed $match
     * @return integer|false
     * @codeCoverageIgnore
     */
    protected function datetimeFound(string $text, &$match): int|false
    {
        return preg_match(RegExPattern::UniversalAndTerrestrialDateTime->value, $text, $match);
    }

    /**
     * Parse a decimal number.
     *
     * @param mixed $match
     * @return integer|false
     * @codeCoverageIgnore
     */
    protected function decimalNumberFound(string $text, &$match): int|false
    {
        $result = preg_match(RegExPattern::RelativeDecimalNumber->value, $text, $match); 
        $match = $match[0];
        return $result;
    }

    /**
     * Parse an astral object name.
     *
     * @param mixed $match
     * @return integer|false
     * @codeCoverageIgnore
     */
    protected function astralObjectFound(string $text, string $regex, &$match): int|false
    {
        return preg_match($regex, $text, $match);       
    }

    /**
     * Split the $text based on the configured 'value_separator'.
     */
    protected function split(string $text): void
    {
        $this->data = explode(Config::get('ephemeris.value_separator'), $text);
    }

    /**
     * Trim the splitted values.
     */
    protected function trim(): void
    {
        foreach ($this->data as $index => $value) {
            $this->data[$index] = trim($value);
        }
    }
} 