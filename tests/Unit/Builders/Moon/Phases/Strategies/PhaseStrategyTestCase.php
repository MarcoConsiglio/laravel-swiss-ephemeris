<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\Moon\Phases\Strategies;

use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Tests\Unit\Builders\StrategyTestCase;

class PhaseStrategyTestCase extends StrategyTestCase
{

    /**
     * Gets a new moon record.
     *
     * @return SynodicRhythmRecord
     */
    protected function getNewMoonRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date->toGregorianUT(), $this->getBiasedAngularDistance(0));
    }

    /**
     * Gets a first quarter record.
     *
     * @return SynodicRhythmRecord
     */
    protected function getFirstQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date->toGregorianUT(), $this->getBiasedAngularDistance(90));
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
            return new SynodicRhythmRecord($this->date->toGregorianUT(), $this->getBiasedAngularDistance(180));
        }
        return new SynodicRhythmRecord($this->date->toGregorianUT(), $this->getBiasedAngularDistance(-180));
    }

    /**
     * Gets a third quarter record.
     *
     * @return SynodicRhythmRecord
     */
    protected function getThirdQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date->toGregorianUT(), $this->getBiasedAngularDistance(-90));
    }

    /**
     * Gets any random record except for new moon.
     *
     * @return SynodicRhythmRecord
     */
    protected function getNonNewMoonRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date->toGregorianUT(), $this->getBiasedAngularDistanceExceptFor(0));
    }

    /**
     * Gets any random record except for first quarter.
     *
     * @return SynodicRhythmRecord
     */
    protected function getNonFirstQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date->toGregorianUT(), $this->getBiasedAngularDistanceExceptFor(90));
    }

    /**
     * Gets any random record except for full moon.
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
     * Gets any random record except for third quarter moon.
     *
     * @return SynodicRhythmRecord
     */
    protected function getNonThirdQuarterRecord(): SynodicRhythmRecord
    {
        return new SynodicRhythmRecord($this->date->toGregorianUT(), $this->getBiasedAngularDistanceExceptFor(-90));
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