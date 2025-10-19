<?php
namespace MarcoConsiglio\Ephemeris\Enums;

/**
 * The command flags refering to the format of the CommandFlag::TimeSteps.
 */
enum TimeSteps: string {
    /**
     * Used with CommandFlag::TimeSteps, the duration in time of each step in years.
     */
    case YearSteps = "y";
    /**
     * Used with CommandFlag::TimeSteps, the duration in time of each step in months.
     */
    case MonthSteps = "mo";
    /**
     * Used with CommandFlag::TimeSteps, the duration in time of each step in minutes.
     */
    case MinuteSteps = "m";
    /**
     * Used with CommandFlag::TimeSteps, the duration in time of each step in minutes.
     */
    case SecondSteps = "s";
}