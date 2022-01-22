<?php
namespace MarcoConsiglio\Ephemeris;

use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Support\Facades\Date;

/**
 * A Carbon class capable to represent the Swiss Ephemeris date formats.
 */
class SwissDateTime extends Carbon
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
     * The format of a Gregorian calendar date expressed in 
     * the Universal Time (UT) aka Greenwich Mean Time (GMT).
     */
    public const GREGORIAN_UT = self::GREGORIAN_DATE." ".self::TIME_FORMAT." ".self::UT;

    /**
     * The format of a Gregorian calendar date expressed in the
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
     * Indicates whether the instance was created with Universal Time.
     *
     * @var boolean
     */
    protected bool $isUniversalTime;

    /**
     * Indicates whether the instance was created with a Gregorian
     * calendar date.
     *
     * @var boolean
     */
    protected bool $isGregorianDate;

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
     * Creates a SwissDateTime from a Gregorian calendar date and a Universal Time.
     *
     * @param string               $date
     * @param string|\DateTimeZone $timezone
     * @return static
     */
    public static function createFromGregorianUT(string $date, string|DateTimeZone $timezone = null): static
    {
        $date = static::rawCreateFromFormat(self::GREGORIAN_UT, $date, $timezone);
        $date->setCreatedWithUniversalTime();
        $date->setCreatedWithGregorianDate();
        return $date;
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
        $date = static::rawCreateFromFormat(self::GREGORIAN_TT, $date, $timezone);
        $date->setCreatedWithTerrestrialTime();
        $date->setCreatedWithGregorianDate();
        return $date;
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
        $date = static::rawCreateFromFormat(self::JULIAN_UT, $date, $timezone);
        $date->setCreatedWithUniversalTime();
        $date->setCreatedWithJulianDate();
        return $date;
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
        $date = static::rawCreateFromFormat(self::JULIAN_TT, $date, $timezone);
        $date->setCreatedWithTerrestrialTime();
        $date->setCreatedWithJulianDate();
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
     * Specifies only once that the instance was created with
     * a Gregorian calendar date. It doesn't change this 
     * status if the instance was created with Julian
     * calendar date.
     *
     * @return void
     */
    public function setCreatedWithGregorianDate(): void
    {
        if (! isset($this->isGregorianDate)) {
            $this->isGregorianDate = true;
        }
    }

    /**
     * Specifies only once that the instance was created with
     * a Julian calendar date. It doesn't change this 
     * status if the instance was created with Julian
     * calendar date.
     *
     * @return void
     */
    public function setCreatedWithJulianDate(): void
    {
        if (! isset($this->isGregorianDate)) {
            $this->isGregorianDate = false;
        }
    }
    

    /**
     * Specifies only once that the instance was created with Universal Time.
     * It doesn't change this status if the instance was created with 
     * Terrestrial Time.
     *
     * @return void
     */
    public function setCreatedWithUniversalTime(): void
    {
        if (! isset($this->isUniversalTime)) {
            $this->isUniversalTime = true;
        }
    }

    /**
     * Specifies only once that the instance was created with Terrestrial Time.
     * It doesn't change this status if the instance was created with 
     * Universal Time.
     *
     * @return void
     */
    public function setCreatedWithTerrestrialTime(): void
    {
        if (! isset($this->isUniversalTime)) {
            $this->isUniversalTime = false;
        }
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