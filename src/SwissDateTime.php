<?php
namespace MarcoConsiglio\Ephemeris;

use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Date;

/**
 * A Carbon class capable to represent the Swiss Ephemeris date formats.
 */
class SwissDateTime extends Carbon
{
    /**
     * The Gregorian calendar date time format.
     */
    public const GREGORIAN_CALENDAR = "d.m.Y G:i:s";

    /**
     * The Julian calendar date time format.
     */
    public const JULIAN_CALENDAR = "d.m.Y\j G:i:s";

    /**
     * The wording that says time is in Universal Time format.
     */
    protected const UT = "\U\T";

    /**
     * The wording that says time is in Terrestrial Time format.
     */
    protected const TT = "\T\T";

    /**
     * The format of a Gregorian calendar date expressed in 
     * the Universal Time (UT) aka Greenwich Mean Time (GMT).
     */
    public const GREGORIAN_UT = self::GREGORIAN_CALENDAR." ".self::UT;

    /**
     * The format of a Gregorian calendar date expressed in the
     * Terrestrial Time (TT).
     */
    public const GREGORIAN_TT = self::GREGORIAN_CALENDAR." ".self::TT;

    /**
     * The format of a Julian calendar date expressed in the 
     * Terrestrial Time (TT).
     */
    public const JULIAN_TT = self::JULIAN_CALENDAR." ".self::TT;

    /**
     * The format of a Julian calendar date expressed in the 
     * Universal Time (UT) aka Greenwich Mean Time (GMT).
     */
    public const JULIAN_UT = self::JULIAN_CALENDAR." ".self::UT;

    /**
     * Formats this date in the Gregorian calendar expressed in
     * Universal Time.
     *
     * @return string
     */
    public function toGregorianUT(): string
    {
        return $this->format(self::GREGORIAN_UT);
    }

    /**
     * Formats this date in the Gregorian calendar expressed in
     * Terrestrial Time.
     *
     * @return string
     */
    public function toGregorianTT(): string
    {
        return $this->format(self::GREGORIAN_TT);
    }

    /**
     * Formats this date in the Julian calendar expressed in
     * Universal Time.
     *
     * @return string
     */
    public function toJulianUT(): string
    {
        return $this->format(self::JULIAN_UT);
    }

    /**
     * Formats this date in the Julian calendar expressed in
     * Terrestrial Time.
     *
     * @return string
     */
    public function toJulianTT(): string
    {
        return $this->format(self::JULIAN_TT);
    }

    /**
     * Creates a SwissDateTime from a Gregorian calendar date and a Universal Time.
     *
     * @param string               $date
     * @param string|\DateTimeZone $timezone
     * @return static
     */
    public static function createFromGregorianUT(string $date, string|DateTimeZone $timezone = null): static
    {
        return static::rawCreateFromFormat(self::GREGORIAN_UT, $date, $timezone);
    }

    /**
     * Creates a SwissDateTime from a Gregorian calendar date and a Terrestrial Time.
     *
     * @param string $date
     * @param string $timezone
     * @return static
     */
    public static function createFromGregorianTT(string $date, string|DateTimeZone $timezone = null): static
    {
        return static::rawCreateFromFormat(self::GREGORIAN_TT, $date, $timezone);
    }
    
    /**
     * Creates a SwissDateTime from a Julian calendar date and a Universal Time.
     *
     * @param string $date
     * @param string $timezone
     * @return static
     */
    public static function createFromJulianUT(string $date, string|DateTimeZone $timezone = null): static
    {
        return static::rawCreateFromFormat(self::JULIAN_UT, $date, $timezone);
    }

    /**
     * Creates a SwissDateTime from a Julian calendar date and a Universal Time.
     *
     * @param string $date
     * @param string $timezone
     * @return static
     */
    public static function createFromJulianTT(string $date, string|DateTimeZone $timezone = null): static
    {
        return static::rawCreateFromFormat(self::JULIAN_TT, $date, $timezone);
    }

    /**
     * Format the instance as a string using the set format
     *
     * @return string
     */
    public function __toString()
    {
        return parent::__toString();
    }
}