<?php
namespace MarcoConsiglio\Ephemeris\Tests\Traits;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Records\DailySpeed;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Random\AngularDistanceRange;
use MarcoConsiglio\Ephemeris\Tests\Random\Generator\AngularDistance as AngularDistanceGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\Generator\Latitude as LatitudeGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\Generator\SwissEphemerisDate as SwissEphemerisDateGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\LatitudeRange;
use MarcoConsiglio\Ephemeris\Tests\Random\SwissEphemerisDateRange;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\AngularDistance as AngularDistanceValidator;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\Latitude as LatitudeValidator;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\SwissEphemerisDate as SwissEphemerisDateValidator;

trait WithRandomData
{
    use WithAngleFaker;
    
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
}