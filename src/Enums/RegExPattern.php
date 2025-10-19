<?php
namespace MarcoConsiglio\Ephemeris\Enums;

/**
 * A list of regular expressions used to match the Swiss Ephemeris response.
 */
enum RegExPattern: string {
    const RegExDelimiter = '/';
    /**
     * Matches a datetime of the Gregorian or Julian calendar, Universal Time or Terrestrial Time.
     */
    case UniversalAndTerrestrialDateTime = self::RegExDelimiter."\d{1,2}\.\d{1,2}\.\d{1,4}j?[[:space:]]{1}\d{1,2}\:\d{2}\:\d{2}[[:space:]](?:(?:TT)|(?:UT)){1}".self::RegExDelimiter;
    /**
     * Matches a negative or positive decimal number.
     */
    case RelativeDecimalNumber = self::RegExDelimiter.'(?<=\s)-?\d+\.\d+\b'.self::RegExDelimiter;
    /**
     * Matches an error within the Swiss Ephemeris output.
     */
    case SwetestError = self::RegExDelimiter."(?:error)(.+)".self::RegExDelimiter;
}