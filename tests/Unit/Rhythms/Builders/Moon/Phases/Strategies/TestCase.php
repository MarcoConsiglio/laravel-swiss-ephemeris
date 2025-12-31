<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Phases\Strategies;

use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\StrategyTestCase;
use MarcoConsiglio\Goniometry\Angle;

class TestCase extends StrategyTestCase
{
    /**
     * Get a new moon record.
     */
    protected function getNewMoonRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord(
            $this->date, 
            Angle::createFromDecimal($this->getBiasedAngularDistance(0)),
            $this->daily_speed
        );
    }

    /**
     * Get a first quarter record.
     */
    protected function getFirstQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord(
            $this->date, 
            Angle::createFromDecimal($this->getBiasedAngularDistance(90)),
            $this->daily_speed
        );
    }

    /**
     * Get a full moon record.
     *
     * @param bool $positive Specify this if the record should be positive or negative,
     * because the angular distance between Sun and Moon tend to +/-180°.
     */
    protected function getFullMoonRecord($positive = true): SynodicRhythmRecord
    {
        if ($positive) {
            return new SynodicRhythmRecord(
                $this->date, 
                Angle::createFromDecimal($this->getBiasedAngularDistance(180)),
                $this->daily_speed
            );
        } else
        return new SynodicRhythmRecord(
            $this->date, 
            Angle::createFromDecimal($this->getBiasedAngularDistance(-180)),
            $this->daily_speed
        );
    }

    /**
     * Get a third quarter record.
     */
    protected function getThirdQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord(
            $this->date, 
            Angle::createFromDecimal($this->getBiasedAngularDistance(-90)),
            $this->daily_speed
        );
    }

    /**
     * Get any random record except for new moon.
     */
    protected function getNonNewMoonRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord(
            $this->date, 
            Angle::createFromDecimal($this->getBiasedAngularDistanceExceptFor(0)),
            $this->daily_speed
        );
    }

    /**
     * Get any random record except for first quarter.
     */
    protected function getNonFirstQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord(
            $this->date, 
            Angle::createFromDecimal($this->getBiasedAngularDistanceExceptFor(90)),
            $this->daily_speed
        );
    }

    /**
     * Get any random record except for full moon.
     */
    protected function getNonFullMoonRecord(): SynodicRhythmRecord
    {
        $angle_value = $this->faker->randomElement([-180, +180]);
        return new SynodicRhythmRecord(
            $this->date, 
            Angle::createFromDecimal($this->getBiasedAngularDistanceExceptFor($angle_value)),
            $this->daily_speed
        );
    }

    /**
     * Get any random record except for third quarter moon.
     */
    protected function getNonThirdQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord(
            $this->date, 
            Angle::createFromDecimal($this->getBiasedAngularDistanceExceptFor(-90)),
            $this->daily_speed
        );
    }

    /**
     * Construct the strategy to test.
     *
     * @param string $strategy
     */
    protected function makeStrategy(SynodicRhythmRecord $record): BuilderStrategy
    {
        $class = $this->tested_class;
        return new $class($record, $this->sampling_rate);
    }
}