<?php
namespace MarcoConsiglio\Ephemeris\Enums\Moon;

/**
 * Moon periods definitions.
 * A moon period is a fraction of a moon phase cycle.
 * 
 * @codeCoverageIgnore
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