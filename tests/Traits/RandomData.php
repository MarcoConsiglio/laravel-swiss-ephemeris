<?php
namespace MarcoConsiglio\Ephemeris\Tests\Traits;

use MarcoConsiglio\Ephemeris\Records\DailySpeed;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Random\Generator\AngularDistanceNeighbourhood as AngularDistanceNeighbourhoodGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\Generator\AngularDistanceOutsideNeighbourhood as AngularDistanceOutsideNeighbourhoodGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\Generator\Latitude as LatitudeGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\Generator\LongitudeNeighbourhood as LongitudeNeighbourhoodGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\Generator\LongitudeOutsideNeighbourhood as LongitudeOutsideNeighbourhoodGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\Generator\SwissEphemerisDate as SwissEphemerisDateGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\LatitudeRange;
use MarcoConsiglio\Ephemeris\Tests\Random\LongitudeRange;
use MarcoConsiglio\Ephemeris\Tests\Random\SwissEphemerisDateRange;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\AngularDistanceNeighbourhood as AngularDistanceNeighbourhoodValidator;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\AngularDistanceOutsideNeighbourhood as AngularDistanceOutsideNeighbourhoodValidator;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\Latitude as LatitudeValidator;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\LongitudeNeighbourhood as LongitudeNeighbourhoodValidator;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\LongitudeOutsideNeighbourhood as LongitudeOutsideNeighbourhoodValidator;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\SwissEphemerisDate as SwissEphemerisDateValidator;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;

trait RandomData
{
    use WithAngleFaker;

    /**
     * The angular neighborhood within which to accept a record.
     * 
     * Represents the maximum error accepted to select some
     * angular ephemeris value and discard others. 
     */
    protected Angle $delta;

    /**
     * Set the delta error angle used to generate inaccurate data.
     */
    protected function setDelta(float|SexadecimalDegrees|Angle $angle): void
    {
        if ($angle instanceof Angle) $this->delta = $angle;
        else $this->delta = Angle::createFromDecimal($angle);
    }

    /**
     * Generate a random speed between $min and $max
     * expressed in degrees per day.
     *
     * @param float $min The slowest speed limit.
     * @param float $max The fastes speed limit.
     */
    protected function randomSpeed(float $min, float $max): float
    {
        return self::$faker->randomFloat(PHP_FLOAT_DIG, $min, $max);
    }

    /**
     * Return a random daily speed
     *
     */
    protected function randomMoonDailySpeed(): DailySpeed
    {
        return DailySpeed::createFromDecimal($this->randomSpeed(10, 14));
    }

    /**
     * Get a random sampling rate expressed in minutes
     * per each step of the ephemeris response.
     */
    protected function randomSamplingRate(): int
    {
        return $this->positiveRandomInteger(1, 1440);
    }

    /**
     * Return a random SwissEphemerisDateTime instance.
     *
     * @param int $min The smallest year of the randomly generated date.
     * @param int $max The largest year of the randomly generated date.
     */
    protected function randomSwissEphemerisDateTime(int $min = 1800, int $max = 2399): SwissEphemerisDateTime
    {
        return new SwissEphemerisDateGenerator(
            self::$faker,
            new SwissEphemerisDateValidator,
            new SwissEphemerisDateRange($min, $max),
        )->generate();
    }

    /**
     * Return a random longitude.
     */
    protected function randomLongitude(float $min = 0.0, float $max = Degrees::MAX): Angle
    {
        return $this->positiveRandomAngle($min, $max);
    }

    /**
     * Return a random longitude within a delta error neighbourhood.
     */
    protected function inaccurateRandomLongitude(float $center_value, int $precision = PHP_FLOAT_DIG): Angle
    {
        return new LongitudeNeighbourhoodGenerator(
            self::$faker,
            new LongitudeNeighbourhoodValidator(
                Angle::createFromDecimal($center_value),
                $this->delta,
            ), new LongitudeRange(0, 0) // Any range is meaningless.
        )->generate($precision);
    }

    /**
     * Return a random longitude outside a delta error neighbourhood.
     */
    protected function inaccurateRandomLongitudeExceptFor(
        float $excluded_center_value, 
        int $precision = PHP_FLOAT_DIG
    ): Angle {
        return new LongitudeOutsideNeighbourhoodGenerator(
            self::$faker,
            new LongitudeOutsideNeighbourhoodValidator(
                Angle::createFromDecimal($excluded_center_value),
                $this->delta
            ),
            new LongitudeRange(0, 0) // Any range is meaningless.
        )->generate($precision);
    }

    /**
     * Return a random latitude.
     */
    protected function randomLatitude(float $min = -90.0, float $max = 90.0, int $precision = PHP_FLOAT_DIG): Angle
    {
        return new LatitudeGenerator(
            self::$faker,
            new LatitudeValidator,
            new LatitudeRange($min, $max)
        )->generate($precision);
    }

    /**
     * Return a random angular distance within a delta error neighbourhood.
     */
    protected function inaccurateRandomAngularDistance(
        float $center_value, 
        int $precision = PHP_FLOAT_DIG
    ): AngularDistance {
        return new AngularDistanceNeighbourhoodGenerator(
            self::$faker,
            new AngularDistanceNeighbourhoodValidator(
                Angle::createFromDecimal($center_value),
                $this->delta
            ),
            new AngularDistanceRange(0, 0) // Any range is meaningless.
        )->generate($precision);
    }

    /**
     * Return a random angular distance outside a delta error neighbourhood.
     */
    protected function inaccurateRandomAngularDistanceExceptFor(
        float $excluded_center_value, 
        int $precision = PHP_FLOAT_DIG
    ): AngularDistance {
        return new AngularDistanceOutsideNeighbourhoodGenerator(
            self::$faker,
            new AngularDistanceOutsideNeighbourhoodValidator(
                Angle::createFromDecimal($excluded_center_value),
                $this->delta
            ),
            new AngularDistanceRange(0, 0) // Any range is meaningless.
        )->generate($precision);
    }
}