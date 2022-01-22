<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Enums;

/**
 * A moon period.
 */
enum MoonPeriodType
{
    /**
     * From new moon to full moon.
     */
    case Waxing;

    /**
     * From full moon to new moon.
     */
    case Waning;
}