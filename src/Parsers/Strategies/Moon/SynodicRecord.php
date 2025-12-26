<?php
namespace MarcoConsiglio\Ephemeris\Parsers\Strategies\Moon;

use MarcoConsiglio\Ephemeris\Parsers\Strategies\ParsingStrategy;

/**
 * The `ParsingStrategy` to find `SynodicRhythmRecord` data.
 */
class SynodicRecord extends ParsingStrategy
{
    /**
     * Return data parsed from raw Swiss Ephemeris output
     * in order to build a `SynodicRhythmRecord`.
     *
     * @return array|null
     */
    public function found(): array|null
    {
        if (
            $this->datetimeFound($this->text, $datetime) &&
            $this->decimalNumberFound($this->text, $decimal)
        ) return [
            $datetime[0],   // Datetime
            $decimal[0],    // Angular distance between moon and sun
            $decimal[1]     // Moon daily speed
        ];
        else return null;
    }
}