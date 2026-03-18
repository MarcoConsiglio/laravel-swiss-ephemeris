<?php
namespace MarcoConsiglio\Ephemeris\Tests\Traits;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
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
    protected function randomAngularDistance(): Angle
    {
        return $this->randomAngle(max: 180);
    }

    /**
     * Return a random Angle between $min° and $max°.
     *
     * @param float $min The minimum degree not lower than -360°.
     * @param float $max The maximum degree not higher than +360°.
     */
    protected function getAngleBetween(float $min = -Degrees::MAX, float $max = Degrees::MAX): Angle
    {
        if ($min < -Degrees::MAX) $min = -Degrees::MAX;
        if ($min > Degrees::MAX) $min = Degrees::MAX;
        if ($max > Degrees::MAX) $max = Degrees::MAX;
        if ($max < -Degrees::MAX) $max = -Degrees::MAX;
        if ($min < 0 && $max < 0)
            return Angle::createFromDecimal(
                $this->negativeRandomFloat(min: abs($max), max: abs($min))
            );
        if ($min >= 0 && $max >= 0)
            return Angle::createFromDecimal(
                $this->positiveRandomFloat(min: $min, max: $max)
            );
        return $this->faker->randomElement([
            Angle::createFromDecimal($this->negativeRandomFloat(min: 0, max: abs($min))),
            Angle::createFromDecimal($this->positiveRandomFloat(min: 0, max: $max))
        ]);
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
        $real_min = min($min, $max);
        $real_max = max($min, $max);
        return $this->faker->randomFloat(PHP_FLOAT_DIG, $real_min, $real_max);
    }

    /**
     * Return a random daily speed
     *
     */
    protected function getRandomMoonDailySpeed(): float
    {
        return $this->getRandomSpeed(10, 14);
    }

    /**
     * Get a random sampling rate expressed in minutes
     * per each step of the ephemeris response.
     */
    protected function getRandomSamplingRate(): int
    {
        return $this->faker->numberBetween(1, 1440);
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
        $random_date = new Carbon($this->faker->dateTimeBetween($min_year, $max_year));
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