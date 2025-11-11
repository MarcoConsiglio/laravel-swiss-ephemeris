<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Strategy;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Ephemeris\Traits\WithFuzzyLogic;

/**
 * Test case for builder strategies.
 */
class StrategyTestCase extends TestCase
{
    use WithFuzzyLogic;

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
        $this->date = SwissEphemerisDateTime::create();
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
        $this->assertInstanceOf($this->record_class, $actual_record, 
            "The $this->strategy_basename strategy must find an instance of type $this->record_class."
        );
        $this->assertObjectEquals($expected_record, $actual_record, "equals", 
            "The $this->strategy_basename strategy failed to find the correct record."
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
        [$min, $max] = $this->getDeltaExtremes(abs($this->delta), $angular_distance, limit: 180);
        return $this->faker->randomFloat(7, $min, $max);
    }

    /**
     * Get a random unprecise longitude biased by a delta.
     *
     * @param float $longitude
     * @return float
     */
    protected function getBiasedLongitude(float $longitude): float
    {
        [$min, $max] = $this->getDeltaExtremes(abs($this->delta), $longitude);
        return $this->faker->randomFloat(7, $min, $max);
    }

    /**
     * Get a random unprecise angular distance except for $angular_distance. 
     *
     * @param float $angular_distance
     * @return float
     */
    protected function getBiasedAngularDistanceExceptFor(float $angular_distance): float
    {
        $limit = 180;
        $max_excluded = 0.0000001;
        $min_excluded = -$max_excluded;
        $limit_excluded = $max_excluded;
        [$min, $max] = $this->getDeltaExtremes($this->delta, $angular_distance, $limit);
        $lower_limits = [-$limit + $limit_excluded, $min - $min_excluded];
        return $this->faker->randomElement([
            $this->faker->randomFloat(7, -$limit + $limit_excluded, $min + $min_excluded),
            $this->faker->randomFloat(7, $max + $max_excluded, $limit)
        ]);
    }

    /**
     * Get a random unprecise longitude except for $longitude. 
     *
     * @param float $longitude
     * @return float
     */
    protected function getBiasedLongitudeExceptFor(float $longitude): float
    {
        $max_excluded = 0.0000001;
        $min_excluded = -$max_excluded;
        $full_angle_excluded = $max_excluded;
        [$min, $max] = $this->getDeltaExtremes($this->delta, $longitude);
        if ($max == 360) {
            return $this->faker->randomFloat(7, 0, $min + $min_excluded);
        }
        if ($min == 0) {
            return $this->faker->randomFloat(7, $max + $max_excluded, 360 - $full_angle_excluded);
        }
        return $this->faker->randomElement([
            $this->faker->randomFloat(7, 0, $min + $min_excluded),
            $this->faker->randomFloat(7, $max + $max_excluded, 360 - $full_angle_excluded)
        ]);
    }

}