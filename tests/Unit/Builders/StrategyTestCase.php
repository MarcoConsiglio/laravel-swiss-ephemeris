<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Strategy;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Ephemeris\Traits\WithFuzzyCondition;

/**
 * Test case for builder strategies.
 */
class StrategyTestCase extends TestCase
{
    use WithFuzzyCondition;

    /**
     * The strategy class name.
     *
     * @var string
     */
    protected string $tested_class;

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
     * A delta bias used for fuzzy conditions.
     *
     * @var float
     */
    protected float $delta = 0.25;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->date = $this->getSwissEphemerisDateTime();
        $this->strategy_basename = class_basename($this->tested_class);
    }


    /**
     * Assert $expected_record equals the $actual_record.
     *
     * @param mixed $expected_record
     * @param mixed $actual_record
     * @return void
     */
    protected function assertRecordFound($expected_record, $actual_record)
    {
        $record_class = get_class($expected_record);
        $this->assertInstanceOf($record_class, $actual_record, 
            "The {$this->strategy_basename} strategy must find an instance of type $record_class."
        );
        $this->assertObjectEquals($expected_record, $actual_record, "equals", 
            "The {$this->strategy_basename} strategy failed to find the correct record."
        );
    }

    /**
     * Asssert the actual record is null.
     *
     * @param mixed $actual_record
     * @return void
     */
    protected function assertRecordNotFound($actual_record)
    {
        $this->assertNull($actual_record, 
            "The {$this->strategy_basename} strategy accepted a record that must be rejected."
        );
    }

/**
     * Get a random unprecise angular distance biased by a delta.
     *
     * @param float $angular_distancce
     * @return float
     */
    protected function getBiasedAngularDistance(float $angular_distance): float
    {
        [$min, $max] = $this->getDeltaExtremes($this->delta, $angular_distance);
        return fake()->randomFloat(1, $min, $max);
    }

    /**
     * Get a random unprecise angular distance except for another biased $angular_distance. 
     *
     * @param float $angular_distance
     * @return float
     */
    protected function getBiasedAngularDistanceExceptFor(float $angular_distance): float
    {
        $error = 0.1;
        [$min, $max] = $this->getDeltaExtremes($this->delta, $angular_distance);
        if ($max > 180) {
            return fake()->randomFloat(1, -180 + abs($this->delta), $min - $error);
        }
        if ($min < -180) {
            return fake()->randomFloat(1, $max + $error, 180 - abs($this->delta));
        }
        return fake()->randomElement([
            fake()->randomFloat(1, -180, $min - $error),
            fake()->randomFloat(1, $max - 0.1, 180)
        ]);
    }

}