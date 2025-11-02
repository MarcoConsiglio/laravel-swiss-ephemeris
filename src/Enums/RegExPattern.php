<?php
namespace MarcoConsiglio\Ephemeris\Enums;

/**
 * A list of regular expressions used to match the Swiss Ephemeris response.
 */
enum RegExPattern: string {
    /**
     * Matches a datetime of the Gregorian or Julian calendar, Universal Time or Terrestrial Time.
    */
    case UniversalAndTerrestrialDateTime = self::RegExDelimiter."\d{1,2}\.\d{1,2}\.-?\d{1,4}j?\s{1}\d{1,2}\:\d{2}\:\d{2}\s(?:(?:TT)|(?:UT)){1}".self::RegExDelimiter;
    /**
     * Matches a negative or positive decimal number.
    */
    case RelativeDecimalNumber = self::RegExDelimiter.'(?:'.self::OneSpaceDelimeter.'|'.self::TwoSpaceDelimiter.'|'.self::ThreeSpaceDelimiter.')-?\d+\.\d+\b'.self::RegExDelimiter;
    /**
     * Matches an error within the Swiss Ephemeris output.
    */
    case SwetestError = self::RegExDelimiter."(?:error)(.+)".self::RegExDelimiter;
    /**
     * Matches a warning within the Swiss Ephemeris output.
    */
    case SwetestWarning = self::RegExDelimiter."(?:warning:)(.+)".self::RegExDelimiter;
    /**
     * Matches a "using" notice within the Swiss Ephemeris output.
     */
    case SwetestUsing = self::RegExDelimiter."(?:using)(.+)".self::RegExDelimiter;
    /**
     * Matches an empty line within the Swiss Ephemeris output.
     */
    case EmptyLine = self::RegExDelimiter."^\s*$".self::RegExDelimiter;
    /**
     * The regular expression delimiter.
     */
    protected const RegExDelimiter = '/';
    /**
     * Matches the string "Moon".
     */
    public const Moon = '(Moon)';
    /**
     * Matches the string "intp. Apogee".
     */
    public const InterpolatedApogee = '(intp\.\sApogee)';
    /**
     * Matches the string "intp. Perigee".
     */
    public const InterpolatedPerigee = '(intp\.\sPerigee)';
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

    /**
     * It constructs a regular expression adding delimiters.
     *
     * @param string $partial_regex
     * @return string
     */
    static public function getRegex(string $partial_regex): string
    {
        return static::RegExDelimiter . $partial_regex . static::RegExDelimiter;
    }
}