<?php
namespace MarcoConsiglio\Ephemeris\Enums;

/**
 * The executable's flags used to query the Swiss Ephemeris.
 */
enum CommandFlag: string {
    /**
     * The objects for which you want to request ephemeris data.
     */
    case ObjectSelection = "p";
    /**
     * The single object for which you wish to request the differential ephemeris.
     */
    case DifferentialObjectSelection = "d";
    /**
     * The single object for which you wish to request the differential ephemeris
     * from a heliocentric perspective.
     */
    case DifferentialHeliocentricalObjectSelection = "dh";
    /**
     * The starting Gregorian date of the requested ephemeris.
     */
    case BeginDate = "b";
    /**
     * The starting Julian date of the requested ephemeris.
     */
    case JulianBeginDate = "bj";
    /**
     * The starting time of the requested ephemeris expressed in Terrestrial Time 
     * (former Ephemeris Time).
     */
    case InputTerrestrialTime = "t";
    /**
     * The starting time of the requested ephemeris expressed in Universal Time.
     */
    case InputUniversalTime = "ut";
    /**
     * The starting time of the requested ephemeris expressed in Universal Time Coordinated.
     */
    case InputUniversalTimeCoordinated = "utc";
    /**
     * The number of lines of the ephemeris response.
     */
    case StepsNumber = "n";
    /**
     * The duration in time of each step in days.
     */
    case TimeSteps = "s";
    /**
     * The format of the ephemeris response.
     */
    case ResponseFormat = "f";
    /**
     * The parameter used to switch on/off the header response.
     */
    case NoHeader = 'head';
}