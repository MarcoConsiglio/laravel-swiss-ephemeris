<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\Moon\Phases\Strategies;

use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\MoonPhaseStrategy;
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
    protected string $strategy_name;

    /**
     * The strategy being tested.
     *
     * @var \MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy
     */
    protected BuilderStrategy $strategy;

    /**
     * A testing date.
     *
     * @var \MarcoConsiglio\Ephemeris\SwissEphemerisDateTime
     */
    protected SwissEphemerisDateTime $date;

    /**
     * A delta bias used for fuzzy conditions.
     *
     * @var float
     */
    protected float $delta = 0.5;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->date = (new SwissEphemerisDateTime)->minutes(0)->seconds(0);
        $this->strategy_name = class_basename($this->tested_class);
        $this->delta = MoonPhaseStrategy::getDelta();
    }

    /**
     * Get a new moon record.
     *
     * @return SynodicRhythmRecord
     */
    protected function getNewMoonRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date->toGregorianUT(), $this->getBiasedAngularDistance(0));
    }

    /**
     * Get a first quarter record.
     *
     * @return SynodicRhythmRecord
     */
    protected function getFirstQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date->toGregorianUT(), $this->getBiasedAngularDistance(90));
    }

    /**
     * Get a full moon record.
     *
     * @param bool $positive Specify this if the record should be positive or negative.
     * @return SynodicRhythmRecord
     */
    protected function getFullMoonRecord($positive = true): SynodicRhythmRecord
    {
        if ($positive) {
            return new SynodicRhythmRecord($this->date->toGregorianUT(), $this->getBiasedAngularDistance(180));
        }
        return new SynodicRhythmRecord($this->date->toGregorianUT(), $this->getBiasedAngularDistance(-180));
    }

    /**
     * Get any record except for third quarter moon.
     *
     * @return SynodicRhythmRecord
     */
    protected function getThirdQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date->toGregorianUT(), $this->getBiasedAngularDistance(-90));
    }

    /**
     * Get any record except for new moon.
     *
     * @return SynodicRhythmRecord
     */
    protected function getNonNewMoonRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date->toGregorianUT(), $this->getBiasedAngularDistanceExceptFor(0));
    }

    /**
     * Get any record except for first quarter.
     *
     * @return SynodicRhythmRecord
     */
    protected function getNonFirstQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date->toGregorianUT(), $this->getBiasedAngularDistanceExceptFor(90));
    }

    /**
     * Get any record except for full moon.
     *
     * @return SynodicRhythmRecord
     */
    protected function getNonFullMoonRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date->toGregorianUT(), fake()->randomElement([
            $this->getBiasedAngularDistanceExceptFor(-180),
            $this->getBiasedAngularDistanceExceptFor(+180)
        ]));
    }

    /**
     * Get any record except for third quarter moon.
     *
     * @return SynodicRhythmRecord
     */
    protected function getNonThirdQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date->toGregorianUT(), $this->getBiasedAngularDistanceExceptFor(-90));
    }

    /**
     * Get an unprecise angular distance biased by a delta.
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
     * Get an unprecise angular distance except for another biased $angular_distance. 
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

    /**
     * Assert expected record equals the actual record.
     *
     * @param mixed $expected_record
     * @param mixed $actual_record
     * @return void
     */
    protected function assertRecordFound($expected_record, $actual_record)
    {
        $this->assertInstanceOf(SynodicRhythmRecord::class, $actual_record, "The {$this->strategy_name} strategy must find a MoonSynodicRhythmRecord.");
        $this->assertObjectEquals($expected_record, $actual_record, "equals", "The {$this->strategy_name} strategy failed to find the correct record.");
    }

    /**
     * Asssert the actual record is null.
     *
     * @param mixed $actual_record
     * @return void
     */
    protected function assertRecordNotFound($actual_record)
    {
        $this->assertNull($actual_record, "The {$this->strategy_name} strategy accepted a record that must be rejected.");
    }

    /**
     * Calculates the min and max extremes for a fuzzy condition.
     *
     * @param float $delta
     * @param float $number
     * @return array The first element is the minimum, the second element is the maximum.
     */
    protected function getDeltaExtremes(float $delta, float $number): array
    {
        $min = $number - abs($delta);
        $max = $number + abs($delta);
        if ($min < -180) {
            $min = -180;
        } 
        if ($max > 180) {
            $max = 180;
        }
        return [
            $number - abs($delta), 
            $number + abs($delta)
        ];
    }

    /**
     * Constructs the strategy to test.
     *
     * @param string                                                $strategy
     * @param SynodicRhythmRecord $record
     * @return \MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy
     */
    protected function makeStrategy(SynodicRhythmRecord $record): BuilderStrategy
    {
        $class = $this->tested_class;
        return new $class($record);
    }
}