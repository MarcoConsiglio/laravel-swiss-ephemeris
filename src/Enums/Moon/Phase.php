<?php
namespace MarcoConsiglio\Ephemeris\Enums\Moon;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\FirstQuarter as FirstQuarterStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\FullMoon as FullMoonStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\NewMoon as NewMoonStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\ThirdQuarter as ThirdQuarterStrategy;

/**
 * Moon phases definitions.
 */
enum Phase
{
    /**
     * 0° angular distance from the Sun.
     */
    case NewMoon;

    /**
     * 90° angular distance from the Sun.
     */
    case FirstQuarter;

    /**
     * +/-180° angular distance from the Sun.
     */
    case FullMoon;

    /**
     * -90° angular distance from the Sun.
     */
    case ThirdQuarter;

    /**
     * Gets the corresponding type associated to a Moon PhaseStrategy concrete class.
     * Every Moon PhaseStrategy must have the same name of the corresponding Moon Phase constant.
     *
     * @param string $strategy_class
     * @return Phase
     */
    public static function getCorrespondingPhase(string $strategy_class): ?Phase
    {
        switch ($strategy_class) {
            case NewMoonStrategy::class:
                return self::NewMoon;
                break; // @codeCoverageIgnore
            case FirstQuarterStrategy::class:
                return self::FirstQuarter;
                break; // @codeCoverageIgnore
            case FullMoonStrategy::class:
                return self::FullMoon;
                break; // @codeCoverageIgnore
            case ThirdQuarterStrategy::class:
                return self::ThirdQuarter;
                break; // @codeCoverageIgnore
        }
        return null;
    }

    /**
     * Gets the corresponsing strategy used to find a MoonPhaseType.
     *
     * @param Phase $type
     * @return string|null
     */
    public static function getCorrespondingStrategy(Phase $type): ?string
    {
        switch ($type) {
            case Phase::NewMoon:
                return NewMoonStrategy::class;
                break; // @codeCoverageIgnore
            case Phase::FirstQuarter:
                return FirstQuarterStrategy::class;
                break; // @codeCoverageIgnore
            case Phase::FullMoon:
                return FullMoonStrategy::class;
                break; // @codeCoverageIgnore
            case Phase::ThirdQuarter:
                return ThirdQuarterStrategy::class;
                break; // @codeCoverageIgnore
        }
        return null;
    }
}