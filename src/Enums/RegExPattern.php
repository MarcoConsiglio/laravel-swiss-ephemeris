<?php
namespace MarcoConsiglio\Ephemeris\Enums;

/**
 * A list of regular expressions used to match the Swiss Ephemeris response.
 */
enum RegExPattern: string {
    /**
     * It matches a datetime of the Gregorian or Julian calendar, Universal Time or Terrestrial Time.
    */
    case UniversalAndTerrestrialDateTime = self::RegExDelimiter."\d{1,2}\.\d{1,2}\.-?\d{1,4}j?\s{1}\d{1,2}\:\d{2}\:\d{2}\s(?:(?:TT)|(?:UT)){1}".self::RegExDelimiter;
    /**
     * It matches a negative or positive decimal number.
    */
    case RelativeDecimalNumber = self::RegExDelimiter.'(?:'.self::OneSpaceDelimeter.'|'.self::TwoSpaceDelimiter.'|'.self::ThreeSpaceDelimiter.')-?\d+\.\d+\b'.self::RegExDelimiter;
    /**
     * It matches an error within the Swiss Ephemeris output.
    */
    case SwetestError = self::RegExDelimiter."(?:error)(.+)".self::RegExDelimiter;
    /**
     * It matches a warning within the Swiss Ephemeris output.
    */
    case SwetestWarning = self::RegExDelimiter."(?:warning:)(.+)".self::RegExDelimiter;
    /**
     * It matches a "using" notice within the Swiss Ephemeris output.
     */
    case SwetestUsing = self::RegExDelimiter."(?:using)(.+)".self::RegExDelimiter;
    /**
     * It matches an empty line within the Swiss Ephemeris output.
     */
    case EmptyLine = self::RegExDelimiter."^\s*$".self::RegExDelimiter;
    /**
     * The regular expression delimiter.
     */
    protected const RegExDelimiter = '/';
    /**
     * It matches the string "Moon".
     */
    public const Moon = '(Moon)';
    /**
     * It matches the string "intp. Apogee".
     */
    public const InterpolatedApogee = '(intp\.\sApogee)';
    /**
     * It matches the string "intp. Perigee".
     */
    public const InterpolatedPerigee = '(intp\.\sPerigee)';
    /**
     * It matches the string "true Node".
     */
    public const TrueNode = '(true\sNode)';
    /**
     * It matches looking back a word bound and one space.
     */
    public const OneSpaceDelimeter = '(?<=\b\s)';
    /**
     * It matches looking back a word bound and two spaces.
     */
    public const TwoSpaceDelimiter = '(?<=\b\s\s)';
    /**
     * It matches looking back a word bound and three spaces.
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