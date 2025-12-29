<?php
namespace MarcoConsiglio\Ephemeris\Parsers\Strategies\Moon;

use MarcoConsiglio\Ephemeris\Enums\RegExPattern;
use MarcoConsiglio\Ephemeris\Parsers\Strategies\ParsingStrategy;

/**
 * The ParsingStrategy used to parse a lunar Node from
 * raw ephemeris data.
 */
class Node extends ParsingStrategy
{
    /**
     * The number of matches for astral object name.
     *
     * @var integer|false
     */
    protected int|false $astral_object_matches_number;

    /**
     * The number of matches for datetime.
     *
     * @var integer|false
     */
    protected int|false $datetime_matches_number;

    /**
     * The number of matches for decimal number.
     *
     * @var integer|false
     */
    protected int|false $decimal_matches_number;

    /**
     * The matched data.
     *
     * @var array
     */
    protected array $match = [];

    /**
     * Find a data line in the raw swiss ephemeris output.
     *
     * @return mixed
     */
    public function found(): array|null
    {
        if ($this->parsedSucceful()) return $this->matches();
        else return null;
    }
    
    /**
     * Perform the parsing action.
     *
     * @return boolean
     */
    private function parsedSucceful(): bool
    {
        $object_name_regex = RegExPattern::getRegex(RegExPattern::Moon."|".RegExPattern::TrueNode);
        $this->astral_object_matches_number = $this->astralObjectFound($this->text, $object_name_regex, $astral_object);
        $this->datetime_matches_number = $this->datetimeFound($this->text, $datetime);
        $this->decimal_matches_number = $this->decimalNumberFound($this->text, $decimal);
        if ($parsed_succesfull = $this->parsedCorrectNumberOfMatches()) {
            $this->match[0] = $astral_object[0];
            $this->match[1] = $datetime[0];
            $this->match[2] = $decimal[0];
            $this->match[3] = $decimal[1];
        }
        return $parsed_succesfull;
    }

    /**
     * Return true if the correct number of matches as been found.
     *
     * @return boolean
     */
    private function parsedCorrectNumberOfMatches(): bool
    {
        return 
            $this->astral_object_matches_number == 1 &&
            $this->datetime_matches_number == 1 &&
            $this->decimal_matches_number == 2;
    }

    /**
     * Return the found matches.
     *
     * @return array
     */
    private function matches(): array
    {
        return [
            $this->match[0],  // Object name
            $this->match[1],  // Datetime
            $this->match[2],  // Object longitude
            $this->match[3]   // Object daily speed
        ];
    }
}