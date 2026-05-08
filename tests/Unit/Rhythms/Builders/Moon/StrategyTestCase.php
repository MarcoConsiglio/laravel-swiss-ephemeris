<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon;

use RoundingMode;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategy;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\StrategyTestCase as TestCase;
use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\Enums\Direction;

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
     */
    #[\Override]
    public function setUp(): void
    {
        parent::setUp();
        // Fake daily speed of the Moon.
        $this->daily_speed = $this->getRandomMoonDailySpeed();
        $this->sampling_rate = $this->getRandomSamplingRate();
        $this->setDelta(
            $this->getDelta(
                $this->daily_speed->toFloat(), 
                $this->sampling_rate
            )
        );
    }
    
    /**
     * Get a random unprecise longitude.
     *
     * @param float $delta
     */
    protected function getBiasedLongitude(float $longitude): float
    {
        [$min, $max] = $this->getDeltaExtremes($this->delta->toFloat(), $longitude);
        return self::$faker->randomFloat(PHP_FLOAT_DIG, $min, $max);
    }

    /**
     * Get a random biased longitude.
     *
     * @param float $delta
     */
    protected function getAbsBiasedLongitude(float $longitude): float
    {
        [$min, $max] = $this->getAbsDeltaExtremes($this->delta->toFloat(), $longitude);
        // $min = $this->toAbsoluteAngularValue($min);
        // $max = $this->toAbsoluteAngularValue($max);
        if ($min > $max) {
            return self::$faker->randomElement([
                self::$faker->randomFloat(PHP_FLOAT_DIG, $min, Degrees::MAX),
                self::$faker->randomFloat(PHP_FLOAT_DIG, 0, $max)
            ]);
        } else return self::$faker->randomFloat(PHP_FLOAT_DIG, $min, $max);
    }


    /**
     * Get a random biased longitude except for $longitude.
     *
     * @param float $delta
     */
    protected function getBiasedLongitudeExceptFor(float $longitude): float
    {
        [$min, $max] = $this->getDeltaExtremes($this->delta->toFloat(), $longitude);
        if ($max == 360) {
            return $this->positiveRandomSexadecimal(0, NextFloat::after($min));
        }
        if ($min == 0) {
            return $this->positiveRandomSexadecimal(NextFloat::before($max));
        }
        return self::$faker->randomElement([
            $this->positiveRandomSexadecimal(0, NextFloat::before($min)),
            $this->positiveRandomSexadecimal(NextFloat::after($max))
        ]);
    }

    /**
     * Get a random biased absolute longitude except for $longitude.
     *
     * @param float $delta
     */
    protected function getAbsBiasedLongitudeExceptFor(float $longitude): float
    {
        $max_excluded = 0.00000000000001;
        $min_excluded = -$max_excluded;
        [$min, $max] = $this->getAbsDeltaExtremes($this->delta->toFloat(), $longitude);
        $min = $this->toAbsoluteAngularValue($min);
        $max = $this->toAbsoluteAngularValue($max);
        if ($min > $max) return self::$faker->randomFloat(PHP_FLOAT_DIG, $max + $max_excluded, $min + $min_excluded);
        else return self::$faker->randomElement([
            self::$faker->randomFloat(PHP_FLOAT_DIG, 0, $min + $min_excluded),
            self::$faker->randomFloat(PHP_FLOAT_DIG, $max + $max_excluded, Degrees::MAX)
        ]);
    }

    /**
     * Return a biased Angle near $longitude.
     */
    protected function getLongitude(float $longitude = 180.0): Angle
    {
        return Angle::createFromDecimal($this->getBiasedLongitude($longitude));
    }
    
    /**
     * Return a biased absolute Angle near $longitude.
     */
    protected function getAbsoluteLongitude(float $longitude = 180.0): Angle
    {
        $longitude = abs($longitude);
        return Angle::createFromDecimal($this->getAbsBiasedLongitude($longitude));
    }

    /**
     * Return a biased Angle except for $longitude.
     */
    protected function getLongitudeExceptFor(float $longitude = 180.0): Angle
    {
        return Angle::createFromDecimal($this->getBiasedLongitudeExceptFor($longitude));
    }

    /**
     * Return a biased Angle except for $longitude.
     */
    protected function getAbsoluteLongitudeExceptFor(float $longitude = 180.0): Angle
    {
        return Angle::createFromDecimal($this->getAbsBiasedLongitudeExceptFor($longitude));
    }

    /**
     * Return the opposite Angle of $longitude.
     */
    protected function getOppositeAbsoluteLongitude(Angle $longitude): Angle
    {
        $opposite = Angle::createFromValues(180, direction: Direction::CLOCKWISE);
        return $longitude->absSum($opposite);
    }

    /**
     * Calculate the delta angle which is the accepted error
     * to found an angle with a precise value.
     */
    protected function getDelta(float $daily_speed, float $sampling_rate): float
    {
        return round(
            $daily_speed * $sampling_rate / 1440 /* minutes */,
            PHP_FLOAT_DIG,
            RoundingMode::HalfTowardsZero
        );
    }

    /**
     * This Guard Assertion checks if the $strategy object
     * implements the correct interface.
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
     */
    protected function checkStrategyExtendsAbstract(object $strategy): void
    {
        $this->assertInstanceOf($this->abstract_strategy, $strategy, 
            $this->mustExtend($this->tested_class, $this->abstract_strategy)
        );
    }
}