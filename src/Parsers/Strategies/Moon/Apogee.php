<?php
namespace MarcoConsiglio\Ephemeris\Parsers\Strategies\Moon;

use MarcoConsiglio\Ephemeris\Enums\RegExPattern;
use MarcoConsiglio\Ephemeris\Parsers\Strategies\ParsingStrategy;

class Apogee extends ParsingStrategy
{
    public function found()
    {
        $object_name_regex = RegExPattern::getRegex(RegExPattern::Moon."|".RegExPattern::InterpolatedApogee);
        if (
            $this->astralObjectFound($this->text, $object_name_regex, $astral_object) &&
            $this->datetimeFound($this->text, $datetime) &&
            $this->decimalNumberFound($this->text, $decimal)
        ) return [
            $astral_object[0],  // Object name
            $datetime[0],       // Datetime
            $decimal[0],        // Object longitude
            $decimal[1]         // Object daily speed
        ];
        else return null;
    }
}