<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Enums;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\FirstQuarter;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\FullMoon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\MoonPhaseStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\NewMoon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\ThirdQuarter;

/**
 * A moon phase.
 */
enum MoonPhaseType
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
     * @return \MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType
     */
    public static function getCorrespondingType(string $strategy_class): ?MoonPhaseType
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
     * @param MoonPhaseType $type
     * @return string|null
     */
    public static function getCorrespondingStrategy(MoonPhaseType $type): ?string
    {
        switch ($type) {
            case MoonPhaseType::NewMoon:
                return NewMoon::class;
                break; // @codeCoverageIgnore
            case MoonPhaseType::FirstQuarter:
                return FirstQuarter::class;
                break; // @codeCoverageIgnore
            case MoonPhaseType::FullMoon:
                return FullMoon::class;
                break; // @codeCoverageIgnore
            case MoonPhaseType::ThirdQuarter:
                return ThirdQuarter::class;
                break; // @codeCoverageIgnore
        }
        return null; // @codeCoverageIgnore
    }
}