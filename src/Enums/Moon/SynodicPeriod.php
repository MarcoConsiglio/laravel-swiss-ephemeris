<?php
namespace MarcoConsiglio\Ephemeris\Enums\Moon;

/**
 * Moon synodic periods definitions.
 * 
 * A Moon synodic period is a fraction of the Moon phase cycle.
 * 
 * @codeCoverageIgnore
 */
enum SynodicPeriod
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