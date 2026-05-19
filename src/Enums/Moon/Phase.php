<?php
namespace MarcoConsiglio\Ephemeris\Enums\Moon;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Phases\FirstQuarter as FirstQuarterStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Phases\FullMoon as FullMoonStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Phases\NewMoon as NewMoonStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Phases\ThirdQuarter as ThirdQuarterStrategy;
use UnhandledMatchError;

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
     * Get the corresponding type associated to a Moon `PhaseStrategy` concrete class.
     * Every Moon `PhaseStrategy` must have the same name of the corresponding Moon `Phase` constant.
     */
    public static function getCorrespondingPhase(string $strategy_class): ?Phase
    {
        try {
            return match ($strategy_class) {
                NewMoonStrategy::class      => self::NewMoon,
                FirstQuarterStrategy::class => self::FirstQuarter,
                FullMoonStrategy::class     => self::FullMoon,
                ThirdQuarterStrategy::class => self::ThirdQuarter
            };
        // @codeCoverageIgnoreStart
        } catch (UnhandledMatchError $error) {}
        // @codeCoverageIgnoreEnd
        return null;
    }

    /**
     * Get the corresponsing strategy used to find a Moon `Phase`.
     */
    public static function getCorrespondingStrategy(Phase $type): string
    {
        return match ($type) {
            self::NewMoon       => NewMoonStrategy::class,
            self::FirstQuarter  => FirstQuarterStrategy::class,
            self::FullMoon      => FullMoonStrategy::class,
            self::ThirdQuarter  => ThirdQuarterStrategy::class
        };
    }
}