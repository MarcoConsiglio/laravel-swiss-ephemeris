<?php
namespace MarcoConsiglio\Ephemeris\Tests\Traits;

use MarcoConsiglio\Ephemeris\Records\DailySpeed;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Random\AngularDistanceRange;
use MarcoConsiglio\Ephemeris\Tests\Random\Generator\AngularDistance as AngularDistanceGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\Generator\NeighbourhoodAngularDistance as NeighbourhoodAngularDistanceGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\Generator\Latitude as LatitudeGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\Generator\OutsideNeighbourhoodAngularDistance as OutsideNeighbourhoodAngularDistanceGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\Generator\SwissEphemerisDate as SwissEphemerisDateGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\LatitudeRange;
use MarcoConsiglio\Ephemeris\Tests\Random\SwissEphemerisDateRange;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\AngularDistance as AngularDistanceValidator;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\Latitude as LatitudeValidator;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\RelativeAngularDelta as RelativeAngularDeltaValidator;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\RelativeOutsideAngularDelta as RelativeOutsideAngularDeltaValidator;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\SwissEphemerisDate as SwissEphemerisDateValidator;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Degrees;
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
     * Return a random angular distance.
     *
     * The angular distance is the angle difference between
     * two stellar objects. Minimum value: -180°. Maximum
     * value: +180°.
     */
    protected function randomAngularDistance(
        float $min = -180.0, 
        float $max = 180.0, 
        int $precision = PHP_FLOAT_DIG
    ): Angle {
        return new AngularDistanceGenerator(
            self::$faker,
            new AngularDistanceValidator,
            new AngularDistanceRange($min, $max)
        )->generate($precision);
    }

    /**
     * Generate a random speed between $min and $max
     * expressed in degrees per day.
     *
     * @param float $min The slowest speed limit.
     * @param float $max The fastes speed limit.
     */
    protected function getRandomSpeed(float $min, float $max): float
    {
        return self::$faker->randomFloat(PHP_FLOAT_DIG, $min, $max);
    }

    /**
     * Return a random daily speed
     *
     */
    protected function getRandomMoonDailySpeed(): DailySpeed
    {
        return DailySpeed::createFromDecimal($this->getRandomSpeed(10, 14));
    }

    /**
     * Get a random sampling rate expressed in minutes
     * per each step of the ephemeris response.
     */
    protected function getRandomSamplingRate(): int
    {
        return $this->positiveRandomInteger(1, 1440);
    }

    /**
     * Return a random SwissEphemerisDateTime instance.
     *
     * @param int $min The smallest year of the randomly generated date.
     * @param int $max The largest year of the randomly generated date.
     */
    protected function getRandomSwissEphemerisDateTime(int $min = 1800, int $max = 2399): SwissEphemerisDateTime
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

    protected function setDelta(float|SexadecimalDegrees $sexadecimal): void
    {
        $this->delta = Angle::createFromDecimal($sexadecimal);
    }

    /**
     * Return an angular distance within a delta error neighbourhood.
     */
    protected function randomErroredAngularDistance(float $center_value, int $precision = PHP_FLOAT_DIG): Angle
    {
        return new NeighbourhoodAngularDistanceGenerator(
            self::$faker,
            new RelativeAngularDeltaValidator(
                Angle::createFromDecimal($center_value),
                $this->delta
            ),
            new AngularDistanceRange(0, 0) // Any range is meaningless.
        )->generate($precision);
    }

    /**
     * Return an angular distance outside a delta error neighbourhood.
     */
    protected function randomErroredAngularDistanceExceptFor(
        float $excluded_center_value, 
        int $precision = PHP_FLOAT_DIG
    ): Angle {
        return new OutsideNeighbourhoodAngularDistanceGenerator(
            self::$faker,
            new RelativeOutsideAngularDeltaValidator(
                Angle::createFromDecimal($excluded_center_value),
                $this->delta
            ),
            new AngularDistanceRange(0, 0) // Any range is meaningless.
        )->generate($precision);
    }
}