<?php
namespace MarcoConsiglio\Ephemeris;

use DateTimeZone;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

/**
 * A Carbon class capable to represent the Swiss Ephemeris date formats.
 */
class SwissEphemerisDateTime extends Carbon
{
    /**
     * The Gregorian calendar date format.
     */
    public const GREGORIAN_DATE = "d.m.Y";

    /**
     * The Julian calendar date format.
     */
    public const JULIAN_DATE = "d.m.Y\j";
    
    /**
     * The time format.
     */
    public const TIME_FORMAT = "G:i:s";

    /**
     * The wording that says time is in Universal Time format.
     */
    protected const UT = "\U\T";

    /**
     * The wording that says time is in Terrestrial Time format.
     */
    protected const TT = "\T\T";

    /**
     * The format of a Gregorian calendar time expressed in 
     * the Universal Time (UT) aka Greenwich Mean Time (GMT).
     */
    public const GREGORIAN_UT = self::GREGORIAN_DATE." ".self::TIME_FORMAT." ".self::UT;

    /**
     * The format of a Gregorian calendar datetime expressed in the
     * Terrestrial Time (TT).
     */
    public const GREGORIAN_TT = self::GREGORIAN_DATE." ".self::TIME_FORMAT." ".self::TT;

    /**
     * The format of a Julian calendar date expressed in the 
     * Terrestrial Time (TT).
     */
    public const JULIAN_TT = self::JULIAN_DATE." ".self::TIME_FORMAT." ".self::TT;

    /**
     * The format of a Julian calendar date expressed in the 
     * Universal Time (UT) aka Greenwich Mean Time (GMT).
     */
    public const JULIAN_UT = self::JULIAN_DATE." ".self::TIME_FORMAT." ".self::UT;

    /**
     * Indicates whether the instance was created with Universal Time,
     * otherwise with Terrestrial Time.
     *
     * @var ?bool
     */
    public ?bool $isUniversalTime = null {
        set(?bool $value) {
            $this->isUniversalTime = $this->isUniversalTime ?? $value;
        }
    }

    /**
     * Indicates whether the instance was created with a Gregorian
     * calendar date, otherwise with a Julian calendar date.
     *
     * @var ?bool
     */
    public ?bool $isGregorianDate = null {
        set(?bool $value) {
            $this->isGregorianDate = $this->isGregorianDate ?? $value;
        }
    }

    /**
     * Formats this date to the Gregorian calendar expressed in
     * Universal Time.
     *
     * @return string
     */
    public function toGregorianUT(): string
    {
        return $this->format(self::GREGORIAN_UT);
    }

    /**
     * Formats this date to the Gregorian calendar expressed in
     * Terrestrial Time.
     *
     * @return string
     */
    public function toGregorianTT(): string
    {
        return $this->format(self::GREGORIAN_TT);
    }

    /**
     * Formats this date to the Julian calendar expressed in
     * Universal Time.
     *
     * @return string
     */
    public function toJulianUT(): string
    {
        return $this->format(self::JULIAN_UT);
    }

    /**
     * Formats this date to the Julian calendar expressed in
     * Terrestrial Time.
     *
     * @return string
     */
    public function toJulianTT(): string
    {
        return $this->format(self::JULIAN_TT);
    }

    /**
     * Formats this date to the Gregorian calendar date.
     *
     * @return string
     */
    public function toGregorianDate(): string
    {
        return $this->format(self::GREGORIAN_DATE);
    }

    /**
     * Formats this date to the Julian calendar date.
     *
     * @return string
     */
    public function toJulianDate(): string
    {
        return $this->format(self::JULIAN_DATE);
    }

    /**
     * Returns all available formats.
     *
     * @return array
     */
    public static function availableFormats(): array
    {
        return [
            self::GREGORIAN_TT,
            self::GREGORIAN_UT,
            self::JULIAN_TT,
            self::JULIAN_UT
        ];
    }

    /**
     * Creates a SwissDateTime from a Gregorian calendar date and a Universal Time.
     *
     * @param string                    $date
     * @param string|\DateTimeZone|null $timezone
     * @return static
     */
    public static function createFromGregorianUT(string $date, string|DateTimeZone|null $timezone = null): static
    {
        $date = static::rawCreateFromFormat(self::GREGORIAN_UT, $date, $timezone);
        $date->isGregorianDate = true;
        $date->isUniversalTime = true;
        return $date;
    }

    /**
     * Creates a SwissDateTime from a Gregorian calendar date and a Terrestrial Time.
     *
     * @param string                    $date
     * @param string|DateTimeZone|null  $timezone
     * @return static
     */
    public static function createFromGregorianTT(string $date, string|DateTimeZone|null $timezone = null): static
    {
        $date = static::rawCreateFromFormat(self::GREGORIAN_TT, $date, $timezone);
        $date->isGregorianDate = true;
        $date->isUniversalTime = false;
        return $date;
    }
    
    /**
     * Creates a SwissDateTime from a Julian calendar date and a Universal Time.
     *
     * @param string                    $date
     * @param string|DateTimeZone|null  $timezone
     * @return static
     */
    public static function createFromJulianUT(string $date, string|DateTimeZone|null $timezone = null): static
    {
        $date = static::rawCreateFromFormat(self::JULIAN_UT, $date, $timezone);
        $date->isGregorianDate = false;
        $date->isUniversalTime = true;
        return $date;
    }

    /**
     * Creates a SwissDateTime from a Julian calendar date and a Universal Time.
     *
     * @param string                    $date
     * @param string|DateTimeZone|null  $timezone
     * @return static
     */
    public static function createFromJulianTT(string $date, string|DateTimeZone|null $timezone = null): static
    {
        $date = static::rawCreateFromFormat(self::JULIAN_TT, $date, $timezone);
        $date->isGregorianDate = false;
        $date->isUniversalTime = false;
        return $date;
    }

    /**
     * Alias of the isUniversalTime method.
     *
     * @return boolean
     */
    public function isUT(): bool
    {
        return $this->isUniversalTime();
    }

    /**
     * Returns whetere this instance is created with
     * a Universal Time.
     *
     * @return boolean
     */
    public function isUniversalTime(): bool
    {
        return $this->isUniversalTime;
    }

    /**
     * Alias of the isTerrestrialTime method.
     *
     * @return boolean
     */
    public function isTT(): bool
    {
        return $this->isTerrestrialTime();
    }

    /**
     * Returns whetere this instance is created with
     * a Terrestrial Time.
     *
     * @return boolean
     */
    public function isTerrestrialTime(): bool
    {
        return ! $this->isUniversalTime;
    }

    /**
     * Returns weather this instance is created with
     * a Gregorian calendar date.
     *
     * @return boolean
     */
    public function isGregorianDate(): bool
    {
        return $this->isGregorianDate;
    }

    /**
     * Returns weather this instance is created with
     * a Julian calendar date.
     *
     * @return boolean
     */
    public function isJulianDate(): bool
    {
        return ! $this->isGregorianDate;
    }

    /**
     * Creates a SwissEphemerisDateTime with one of the
     * available Swiss Ephemeris formats.
     * 
     * If $timestamp came from Swiss Ephemeris, you can 
     * build this class instance without know what format
     * $timestamp has.
     *
     * @param string $timestamp
     * @return SwissEphemerisDateTime
     * @throws InvalidFormatException if $timestamp doesn't match any of the available formats.
     */
    public static function createFromSwissEphemerisFormat(string $timestamp): SwissEphemerisDateTime
    {
        $datetime_class = SwissEphemerisDateTime::class;
        foreach (SwissEphemerisDateTime::availableFormats() as $format) {
            if (SwissEphemerisDateTime::canBeCreatedFromFormat($timestamp, $format)) {
                return SwissEphemerisDateTime::rawCreateFromFormat($format, $timestamp);
            }
        }
        throw new InvalidFormatException("The string $timestamp doesn't match any of the available formats in $datetime_class class.");
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