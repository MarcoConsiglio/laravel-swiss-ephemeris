<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\MoonPhases\Strategies;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Tests\TestCase as BaseTestCase;
use MarcoConsiglio\Ephemeris\Traits\WithFuzzyCondition;

/**
 * Test case for builder strategies.
 */
class StrategyTestCase extends BaseTestCase
{
    use WithFuzzyCondition;

    /**
     * The strategy class name.
     *
     * @var string
     */
    protected string $tested_class;

    /**
     * A testing date.
     *
     * @var \Carbon\Carbon
     */
    protected Carbon $date;

    /**
     * A delta bias used for fuzzy conditions.
     *
     * @var float
     */
    protected float $delta = 1;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->date = (new Carbon)->minutes(0)->seconds(0);
    }

    /**
     * Get a new moon record.
     *
     * @return \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord
     */
    protected function getNewMoonRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date, $this->getBiasedAngularDistance(0));
    }

    /**
     * Get a first quarter record.
     *
     * @return \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord
     */
    protected function getFirstQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date, $this->getBiasedAngularDistance(90));
    }

    /**
     * Get a full moon record.
     *
     * @param bool $positive Specify this if the record should be positive or negative.
     * @return \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord
     */
    protected function getFullMoonRecord($positive = true): SynodicRhythmRecord
    {
        if ($positive) {
            return new SynodicRhythmRecord($this->date, $this->getBiasedAngularDistance(180));
        }
        return new SynodicRhythmRecord($this->date, $this->getBiasedAngularDistance(-180));
    }

    /**
     * Get any record except for third quarter moon.
     *
     * @return \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord
     */
    protected function getThirdQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date, $this->getBiasedAngularDistance(-90));
    }

    /**
     * Get any record except for new moon.
     *
     * @return \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord
     */
    protected function getNonNewMoonRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date, $this->getBiasedAngularDistanceExceptFor(0));
    }

    /**
     * Get any record except for first quarter.
     *
     * @return \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord
     */
    protected function getNonFirstQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date, $this->getBiasedAngularDistanceExceptFor(90));
    }

    /**
     * Get any record except for full moon.
     *
     * @return \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord
     */
    protected function getNonFullMoonRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date, $this->faker->randomElement([
            $this->getBiasedAngularDistanceExceptFor(-180),
            $this->getBiasedAngularDistanceExceptFor(+180)
        ]));
    }

    /**
     * Get any record except for third quarter moon.
     *
     * @return \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord
     */
    protected function getNonThirdQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date, $this->getBiasedAngularDistanceExceptFor(-90));
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
        return $this->faker->randomFloat(1, $min, $max);
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
            return $this->faker->randomFloat(1, -180 + abs($this->delta), $min - $error);
        }
        if ($min < -180) {
            return $this->faker->randomFloat(1, $max + $error, 180 - abs($this->delta));
        }
        return $this->faker->randomElement([
            $this->faker->randomFloat(1, -180, $min - $error),
            $this->faker->randomFloat(1, $max - 0.1, 180)
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
        $this->assertInstanceOf(SynodicRhythmRecord::class, $actual_record, "The {$this->tested_class} strategy must find a SynodicRhythmRecord.");
        $this->assertObjectEquals($expected_record, $actual_record, "equals", "The {$this->tested_class} strategy failed to find the correct record.");
    }

    /**
     * Asssert the actual record is null.
     *
     * @param mixed $actual_record
     * @return void
     */
    protected function assertRecordNotFound($actual_record)
    {
        $this->assertNull($actual_record, "The {$this->tested_class} strategy accepted a record that must be rejected.");
    }
}