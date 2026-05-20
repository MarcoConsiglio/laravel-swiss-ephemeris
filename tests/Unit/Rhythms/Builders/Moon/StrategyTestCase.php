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
use MarcoConsiglio\Goniometry\Enums\Rotation;

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
        $this->daily_speed = $this->randomMoonDailySpeed();
        $this->sampling_rate = $this->randomSamplingRate();
        $this->setDelta(
            $this->getDelta(
                $this->daily_speed->toFloat(), 
                $this->sampling_rate
            )
        );
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