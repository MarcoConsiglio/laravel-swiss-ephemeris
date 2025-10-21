<?php
namespace MarcoConsiglio\Ephemeris\Enums\Moon;

/**
 * A moon period.
 */
enum Period
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