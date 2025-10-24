<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\Moon\Phases\Strategies;

use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Tests\Unit\Builders\StrategyTestCase;

class PhaseStrategyTestCase extends StrategyTestCase
{

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
     * @param bool $positive Specify this if the record should be positive or negative, 
     * because the angular distance between Sun and Moon tend to +/-180°.
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
     * Get a third quarter record.
     *
     * @return SynodicRhythmRecord
     */
    protected function getThirdQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date->toGregorianUT(), $this->getBiasedAngularDistance(-90));
    }

    /**
     * Get any random record except for new moon.
     *
     * @return SynodicRhythmRecord
     */
    protected function getNonNewMoonRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date->toGregorianUT(), $this->getBiasedAngularDistanceExceptFor(0));
    }

    /**
     * Get any random record except for first quarter.
     *
     * @return SynodicRhythmRecord
     */
    protected function getNonFirstQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date->toGregorianUT(), $this->getBiasedAngularDistanceExceptFor(90));
    }

    /**
     * Get any random record except for full moon.
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
     * Get any random record except for third quarter moon.
     *
     * @return SynodicRhythmRecord
     */
    protected function getNonThirdQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date->toGregorianUT(), $this->getBiasedAngularDistanceExceptFor(-90));
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

    /**
     * Constructs the strategy to test.
     *
     * @param string $strategy
     * @param SynodicRhythmRecord $record
     * @return BuilderStrategy
     */
    protected function makeStrategy(SynodicRhythmRecord $record): BuilderStrategy
    {
        $class = $this->tested_class;
        return new $class($record);
    }
}