<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders;

use MarcoConsiglio\Ephemeris\Records\Moon\AnomalisticRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Strategy;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Ephemeris\Traits\WithFuzzyLogic;
use RoundingMode;

/**
 * Test case for builder strategies.
 */
class StrategyTestCase extends TestCase
{
    use WithFuzzyLogic;

    /**
     * The sampling rate of the ephemeris.
     *
     * @var integer
     */
    protected int $sampling_rate;

    /**
     * The angular neighborhood within which to accept a record.
     *
     * @var float
     */
    protected float $delta;

    /**
     * A fake daily speed of the Moon expressed in decimal degrees.
     *
     * @var float
     */
    protected float $daily_speed;

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
        $this->assertInstanceOf($this->record_class, $actual_record, <<<TEXT
The {$this->strategy_basename} strategy must find an instance of type {$this->record_class} with delta {$this->delta}° and sampling rate {$this->sampling_rate} min.
The accepted record should be:
$expected_record
TEXT
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
        $this->assertNull($actual_record, <<<TEXT
The {$this->strategy_basename} strategy accepted a record that must be rejected with delta {$this->delta}° and sampling rate {$this->sampling_rate} min.
The record to be rejected is:
$actual_record
TEXT
        );
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
     * Get a random unprecise longitude biased by a delta.
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
     * Get a random unprecise longitude except for $longitude. 
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
            return $this->faker->randomFloat(PHP_FLOAT_DIG, $max + $max_excluded, 360);
        }
        return $this->faker->randomElement([
            $this->faker->randomFloat(PHP_FLOAT_DIG, 0, $min + $min_excluded),
            $this->faker->randomFloat(PHP_FLOAT_DIG, $max + $max_excluded, 360)
        ]);
    }

    protected function getDelta(float $daily_speed, float $sampling_rate): float
    {
        return round(
            $daily_speed * $sampling_rate / 1440 /* minutes */,
            PHP_FLOAT_DIG,
            RoundingMode::HalfTowardsZero
        );
    }
}