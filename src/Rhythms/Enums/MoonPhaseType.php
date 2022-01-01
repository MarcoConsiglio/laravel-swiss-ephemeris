<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Enums;
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
}