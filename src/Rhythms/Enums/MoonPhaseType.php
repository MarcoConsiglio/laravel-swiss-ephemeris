<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Enums;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\MoonPhaseStrategy;

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
     * Every MoonPhaseStrategy must have the same name of the corresponding MoonPhaseType value.
     *
     * @param string $strategy_class
     * @return \MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType
     */
    public static function getCorrespondingType(string $strategy_class): ?MoonPhaseType
    {
        if (class_exists($strategy_class) && get_parent_class($strategy_class) == MoonPhaseStrategy::class) {
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
            }
        }
        return null;
    }
}