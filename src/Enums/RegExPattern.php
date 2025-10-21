<?php
namespace MarcoConsiglio\Ephemeris\Enums;

/**
 * A list of regular expressions used to match the Swiss Ephemeris response.
 */
enum RegExPattern: string {
    protected const RegExDelimiter = '/';
    /**
     * Matches a datetime of the Gregorian or Julian calendar, Universal Time or Terrestrial Time.
     */
    case UniversalAndTerrestrialDateTime = self::RegExDelimiter."\d{1,2}\.\d{1,2}\.\d{1,4}j?\s{1}\d{1,2}\:\d{2}\:\d{2}\s(?:(?:TT)|(?:UT)){1}".self::RegExDelimiter;
    /**
     * Matches a negative or positive decimal number.
     */
    case RelativeDecimalNumber = self::RegExDelimiter.'(?:'.self::OneSpaceDelimeter.'|'.self::TwoSpaceDelimiter.'|'.self::ThreeSpaceDelimiter.')-?\d+\.\d+\b'.self::RegExDelimiter;
    /**
     * Matches an error within the Swiss Ephemeris output.
     */
    case SwetestError = self::RegExDelimiter."(?:error)(.+)".self::RegExDelimiter;
    /**
     * Matches the string "Moon".
     */
    public const Moon = '(Moon)';
    /**
     * Matches the string "intp. Apogee".
     */
    public const InterpolatedApogee = '(intp\.\sApogee)';
    /**
     * Matches looking back a word bound and one space.
     */
    public const OneSpaceDelimeter = '(?<=\b\s)';
    /**
     * Matches looking back a word bound and two spaces.
     */
    public const TwoSpaceDelimiter = '(?<=\b\s\s)';
    /**
     * Matches looking back a word bound and three spaces.
     */
    public const ThreeSpaceDelimiter = '(?<=\b\s\s\s)';

    static public function getObjectNamesRegex(string $partial_regex): string
    {
        return static::RegExDelimiter . $partial_regex . static::RegExDelimiter;
    }
}