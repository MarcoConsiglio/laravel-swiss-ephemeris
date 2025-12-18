<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategy;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Goniometry\Angle;
use RoundingMode;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\StrategyTestCase as TestCase;

/**
 * Test case for Moon builder strategies.
 */
abstract class StrategyTestCase extends TestCase
{

    /**
     * The strategy class name.
     *
     * @var string
     */
    protected string $tested_class;

    /**
     * The record type that the
     * strategy accept.
     *
     * @var string
     */
    protected string $record_class;

    /**
     * The strategy name.
     *
     * @var string
     */
    protected string $strategy_basename;

    /**
     * The interface implemented in concrete strategies.
     *
     * @var string
     */
    protected string $strategy_interface = BuilderStrategy::class;

    /**
     * The abstract class extended by a concrete strategy.
     *
     * @var string
     */
    protected string $abstract_strategy = Strategy::class;
    

    /**
     * The strategy being tested.
     *
     * @var BuilderStrategy
     */
    protected BuilderStrategy $strategy;

    /**
     * A testing date.
     *
     * @var SwissEphemerisDateTime
     */
    protected SwissEphemerisDateTime $date;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        // Fake daily speed of the Moon.
        $this->daily_speed = $this->getRandomMoonDailySpeed();
        $this->sampling_rate = $this->getRandomSamplingRate();
        $this->delta = $this->getDelta($this->daily_speed, $this->sampling_rate);
    }

    /**
     * Get a random unprecise angular distance biased by a delta.
     *
     * @param float $angular_distance
     * @param float $delta
     * @return float
     */
    protected function getBiasedAngularDistance(float $angular_distance): float
    {
        [$min, $max] = $this->getDeltaExtremes($this->delta, $angular_distance, limit: 180);
        return $this->faker->randomFloat(PHP_FLOAT_DIG, $min, $max);
    }

    /**
     * Get a random unprecise angular distance except for $angular_distance. 
     *
     * @param float $angular_distance
     * @param float $delta
     * @return float
     */
    protected function getBiasedAngularDistanceExceptFor(float $angular_distance): float
    {
        $limit = 180;
        $max_excluded = 0.00000000000001;
        $min_excluded = $max_excluded;
        $limit_excluded = $max_excluded;
        [$min, $max] = $this->getDeltaExtremes($this->delta, $angular_distance, $limit);
        if ($min == -180) {
            return $this->faker->randomFloat(PHP_FLOAT_DIG, $max + $max_excluded, $limit - $limit_excluded);
        }
        if ($max == 180) {
            return $this->faker->randomFloat(PHP_FLOAT_DIG, -$limit + $limit_excluded, $min - $min_excluded);
        }
        return $this->faker->randomElement([
            $this->faker->randomFloat(PHP_FLOAT_DIG, -$limit + $limit_excluded, $min - $min_excluded),
            $this->faker->randomFloat(PHP_FLOAT_DIG, $max + $max_excluded, $limit - $limit_excluded)
        ]);
    }
    
    /**
     * Get a random unprecise longitude.
     *
     * @param float $longitude
     * @param float $delta
     * @return float
     */
    protected function getBiasedLongitude(float $longitude): float
    {
        [$min, $max] = $this->getDeltaExtremes($this->delta, $longitude);
        return $this->faker->randomFloat(PHP_FLOAT_DIG, $min, $max);
    }

    /**
     * Get a random biased longitude.
     *
     * @param float $longitude
     * @param float $delta
     * @return float
     */
    protected function getAbsBiasedLongitude(float $longitude): float
    {
        [$min, $max] = $this->getAbsDeltaExtremes($this->delta, $longitude);
        // $min = $this->toAbsoluteAngularValue($min);
        // $max = $this->toAbsoluteAngularValue($max);
        if ($min > $max) {
            return $this->faker->randomElement([
                $this->faker->randomFloat(PHP_FLOAT_DIG, $min, Angle::MAX_DEGREES),
                $this->faker->randomFloat(PHP_FLOAT_DIG, 0, $max)
            ]);
        } else return $this->faker->randomFloat(PHP_FLOAT_DIG, $min, $max);
    }


    /**
     * Get a random biased longitude except for $longitude. 
     *
     * @param float $longitude
     * @param float $delta
     * @return float
     */
    protected function getBiasedLongitudeExceptFor(float $longitude): float
    {
        $max_excluded = 0.00000000000001;
        $min_excluded = -$max_excluded;
        [$min, $max] = $this->getDeltaExtremes($this->delta, $longitude);
        if ($max == 360) {
            return $this->faker->randomFloat(PHP_FLOAT_DIG, 0, $min + $min_excluded);
        }
        if ($min == 0) {
            return $this->faker->randomFloat(PHP_FLOAT_DIG, $max + $max_excluded, Angle::MAX_DEGREES);
        }
        return $this->faker->randomElement([
            $this->faker->randomFloat(PHP_FLOAT_DIG, 0, $min + $min_excluded),
            $this->faker->randomFloat(PHP_FLOAT_DIG, $max + $max_excluded, Angle::MAX_DEGREES)
        ]);
    }

    /**
     * Get a random biased absolute longitude except for $longitude. 
     *
     * @param float $longitude
     * @param float $delta
     * @return float
     */
    protected function getAbsBiasedLongitudeExceptFor(float $longitude): float
    {
        $max_excluded = 0.00000000000001;
        $min_excluded = -$max_excluded;
        [$min, $max] = $this->getAbsDeltaExtremes($this->delta, $longitude);
        $min = $this->toAbsoluteAngularValue($min);
        $max = $this->toAbsoluteAngularValue($max);
        if ($min > $max) return $this->faker->randomFloat(PHP_FLOAT_DIG, $max + $max_excluded, $min + $min_excluded);
        else return $this->faker->randomElement([
            $this->faker->randomFloat(PHP_FLOAT_DIG, 0, $min + $min_excluded),
            $this->faker->randomFloat(PHP_FLOAT_DIG, $max + $max_excluded, Angle::MAX_DEGREES)
        ]);
    }

    /**
     * Return a biased Angle near $longitude.
     *
     * @param float $longitude
     * @return Angle
     */
    protected function getLongitude(float $longitude = 180.0): Angle
    {
        return Angle::createFromDecimal($this->getBiasedLongitude($longitude, $this->delta));
    }
    
    /**
     * Return a biased absolute Angle near $longitude.
     *
     * @param float $longitude
     * @return Angle
     */
    protected function getAbsoluteLongitude(float $longitude = 180.0): Angle
    {
        $longitude = abs($longitude);
        return Angle::createFromDecimal($this->getAbsBiasedLongitude($longitude, $this->delta));
    }

    /**
     * Return a biased Angle except for $longitude.
     *
     * @param float $longitude
     * @return Angle
     */
    protected function getLongitudeExceptFor(float $longitude = 180.0): Angle
    {
        return Angle::createFromDecimal($this->getBiasedLongitudeExceptFor($longitude, $this->delta));
    }

    /**
     * Return a biased Angle except for $longitude.
     *
     * @param float $longitude
     * @return Angle
     */
    protected function getAbsoluteLongitudeExceptFor(float $longitude = 180.0): Angle
    {
        return Angle::createFromDecimal($this->getAbsBiasedLongitudeExceptFor($longitude, $this->delta));
    }

    /**
     * Return the opposite Angle of $longitude.
     *
     * @param Angle $longitude
     * @return Angle
     */
    protected function getOppositeAbsoluteLongitude(Angle $longitude): Angle
    {
        $opposite = Angle::createFromValues(180, direction: Angle::CLOCKWISE);
        $result = Angle::absSum($longitude, $opposite);
        return $result;
    }

    /**
     * Calculate the delta angle which is the accepted error
     * to found an angle with a precise value.
     *
     * @param float $daily_speed
     * @param float $sampling_rate
     * @return float
     */
    protected function getDelta(float $daily_speed, float $sampling_rate): float
    {
        return round(
            abs($daily_speed) * abs($sampling_rate) / 1440 /* minutes */,
            PHP_FLOAT_DIG,
            RoundingMode::HalfTowardsZero
        );
    }

    /**
     * This Guard Assertion checks if the $strategy object
     * implements the correct interface.
     *
     * @param object $strategy
     * @return void
     */
    protected function checkStrategyImplementsInterface(object $strategy): void
    {
        $this->assertInstanceOf($this->strategy_interface, $strategy, 
            $this->mustImplement($this->tested_class, $this->strategy_interface)
        );
    }

    /**
     * This Guard Assertion checks if the $strategy object
     * extends the correct abstract strategy.
     *
     * @param object $strategy
     * @return void
     */
    protected function checkStrategyExtendsAbstract(object $strategy): void
    {
        $this->assertInstanceOf($this->abstract_strategy, $strategy, 
            $this->mustExtend($this->tested_class, $this->abstract_strategy)
        );
    }
}