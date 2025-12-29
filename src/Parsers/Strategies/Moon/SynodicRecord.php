<?php
namespace MarcoConsiglio\Ephemeris\Parsers\Strategies\Moon;

use MarcoConsiglio\Ephemeris\Parsers\Strategies\ParsingStrategy;

/**
 * The `ParsingStrategy` to find `SynodicRhythmRecord` data.
 */
class SynodicRecord extends ParsingStrategy
{
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
     * @todo This method should be moved to ParsingStrategy.
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
     * @todo This method should be abstract and moved to ParsingStrategy.
     */
    private function parsedSucceful(): bool
    {
        $this->datetime_matches_number = $this->datetimeFound($this->text, $datetime);
        $this->decimal_matches_number = $this->decimalNumberFound($this->text, $decimal);
        if ($parsed_succesfull = $this->parsedCorrectNumberOfMatches()) {
            $this->match[0] = $datetime[0];
            $this->match[1] = $decimal[0];
            $this->match[2] = $decimal[1];
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
            $this->datetime_matches_number == 1 &&
            $this->decimal_matches_number == 2;
    }

    /**
     * Return the found matches.
     *
     * @return array
     * @todo This method should be abstract moved to ParsingStrategy.
     */
    private function matches(): array
    {
        return [
            $this->match[0],  // Datetime
            $this->match[1],  // Object longitude
            $this->match[2]   // Object daily speed
        ];
    }
}