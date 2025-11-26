<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Phases\Strategies;

use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\StrategyTestCase;
use MarcoConsiglio\Goniometry\Angle;

class PhaseStrategyTestCase extends StrategyTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        // Fake daily speed of the Moon.
        $this->daily_speed = $this->faker->randomFloat(7, 10, 14);
        $synodic_month = 29.530588;
        $this->sampling_rate = $this->faker->numberBetween(30, intval($synodic_month / 4 * 24 * 60));
        $this->delta = $this->getDelta($this->daily_speed, $this->sampling_rate);
    }

    /**
     * Gets a new moon record.
     *
     * @return SynodicRhythmRecord
     */
    protected function getNewMoonRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord(
            $this->date, 
            Angle::createFromDecimal($this->getBiasedAngularDistance(0, $this->delta)),
            $this->daily_speed
        );
    }

    /**
     * Gets a first quarter record.
     *
     * @return SynodicRhythmRecord
     */
    protected function getFirstQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord(
            $this->date, 
            Angle::createFromDecimal($this->getBiasedAngularDistance(90, $this->delta)),
            $this->daily_speed
        );
    }

    /**
     * Gets a full moon record.
     *
     * @param bool $positive Specify this if the record should be positive or negative, 
     * because the angular distance between Sun and Moon tend to +/-180°.
     * @return SynodicRhythmRecord
     */
    protected function getFullMoonRecord($positive = true): SynodicRhythmRecord
    {
        if ($positive) {
            return new SynodicRhythmRecord(
                $this->date, 
                Angle::createFromDecimal($this->getBiasedAngularDistance(180, $this->delta)),
                $this->daily_speed
            );
        } else
        return new SynodicRhythmRecord(
            $this->date, 
            Angle::createFromDecimal($this->getBiasedAngularDistance(-180, $this->delta)),
            $this->daily_speed
        );
    }

    /**
     * Gets a third quarter record.
     *
     * @return SynodicRhythmRecord
     */
    protected function getThirdQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord(
            $this->date, 
            Angle::createFromDecimal($this->getBiasedAngularDistance(-90, $this->delta)),
            $this->daily_speed
        );
    }

    /**
     * Gets any random record except for new moon.
     *
     * @return SynodicRhythmRecord
     */
    protected function getNonNewMoonRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord(
            $this->date, 
            Angle::createFromDecimal($this->getBiasedAngularDistanceExceptFor(0, $this->delta)),
            $this->daily_speed
        );
    }

    /**
     * Gets any random record except for first quarter.
     *
     * @return SynodicRhythmRecord
     */
    protected function getNonFirstQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord(
            $this->date, 
            Angle::createFromDecimal($this->getBiasedAngularDistanceExceptFor(90, $this->delta)),
            $this->daily_speed
        );
    }

    /**
     * Gets any random record except for full moon.
     *
     * @return SynodicRhythmRecord
     */
    protected function getNonFullMoonRecord(): SynodicRhythmRecord
    {
        $angle_value = $this->faker->randomElement([-180, +180]);
        return new SynodicRhythmRecord(
            $this->date, 
            Angle::createFromDecimal($this->getBiasedAngularDistanceExceptFor($angle_value, $this->delta)),
            $this->daily_speed
        );
    }

    /**
     * Gets any random record except for third quarter moon.
     *
     * @return SynodicRhythmRecord
     */
    protected function getNonThirdQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord(
            $this->date, 
            Angle::createFromDecimal($this->getBiasedAngularDistanceExceptFor(-90, $this->delta)),
            $this->daily_speed
        );
    }

    /**
     * It constructs the strategy to test.
     *
     * @param string $strategy
     * @param SynodicRhythmRecord $record
     * @return BuilderStrategy
     */
    protected function makeStrategy(SynodicRhythmRecord $record): BuilderStrategy
    {
        $class = $this->tested_class;
        return new $class($record, $this->sampling_rate);
    }
}