<?php
namespace MarcoConsiglio\Ephemeris\Enums\Moon;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\FirstQuarter as FirstQuarterStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\FullMoon as FullMoonStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\NewMoon as NewMoonStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\ThirdQuarter as ThirdQuarterStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\MoonPhaseStrategy;

/**
 * A moon phase.
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
     * Gets the corresponding type associated to a MoonPhaseStrategy concrete class.
     * Every MoonPhaseStrategy must have the same name of the corresponding MoonPhaseType constant.
     *
     * @param string $strategy_class
     * @return Phase
     */
    public static function getCorrespondingType(string $strategy_class): ?Phase
    {
        if (get_parent_class($strategy_class) == MoonPhaseStrategy::class) {
            $value = class_basename($strategy_class);
            switch ($value) {
                case "NewMoon":
                    return self::NewMoon;
                    break;
                case "FirstQuarter":
                    return self::FirstQuarter;
                    break;
                case "FullMoon":
                    return self::FullMoon;
                    break;
                case "ThirdQuarter":
                    return self::ThirdQuarter;
                    break;
                default:
                    return null;
                    break;
            }
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
        return null; // @codeCoverageIgnore
    }
}