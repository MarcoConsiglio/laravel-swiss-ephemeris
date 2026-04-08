<?php
namespace MarcoConsiglio\Ephemeris\Tests\Traits;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Records\DailySpeed;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Random\AngularDistanceRange;
use MarcoConsiglio\Ephemeris\Tests\Random\Generator\AngularDistance as AngularDistanceGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\AngularDistance as AngularDistanceValidator;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Traits\WithAngleFaker;

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
     * @param integer $min_year The smallest year of a random date generation.
     * @param integer $max_year The largest year of generating a random date.
     */
    protected function getRandomSwissEphemerisDateTime(int $min_year = 1800, int $max_year = 2399): SwissEphemerisDateTime
    {
        $min_year = "$min_year-01-01";
        $max_year = "$max_year-12-31";
        $random_date = new Carbon(self::$faker->dateTimeBetween($min_year, $max_year));
        return SwissEphemerisDateTime::createFromCarbon($random_date);
    }

    /**
     * Create a random Angle.
     *
     * @param float|null $limit It limits the angle to $limit decimal degrees.
     */
    protected function getRandomAngle(float|null $limit = null): Angle
    {
        if ($limit === null) return $this->randomAngle();
        return $this->randomAngle(max: $limit);
    }

    /**
     * Create a random positive Angle.
     *
     * @param float|null $limit It limits the angle to $limit decimal degrees.
     */
    protected function getRandomPositiveAngle(float|null $limit = null): Angle
    {
        if ($limit === null) return $this->positiveRandomAngle();
        return $this->positiveRandomAngle(max: $limit);   
    }

    /**
     * Return a random positive sexadecimal value, useful to create an Angle from
     * a decimal value.
     */
    protected function getRandomPositiveSexadecimalValue(float|null $limit = null): float
    {
        if ($limit !== null) {
            $limit = abs($limit);
            if ($limit > Degrees::MAX) $limit = Degrees::MAX;
        }
        $limit ??= Degrees::MAX;
        return $this->faker->randomFloat(PHP_FLOAT_DIG, 0, $limit);
    }

    /**
     * Return a random relative (positive or negative) sexadecimal value, useful
     * to create an Angle from a decimal value.
     */
    protected function getRandomRelativeSexadecimalValue(float|null $limit = null): float
    {
        $value = $this->getRandomPositiveSexadecimalValue($limit);
        return $this->faker->randomElement([-$value, $value]);
    }
}