<?php
namespace MarcoConsiglio\Ephemeris\Enums;

/**
 * The Swiss ephemeris responses are formatted with the 
 * following codes. Each code corresponds to a column of 
 * a data type.
 * 
 * @codeCoverageIgnore
 */
enum OutputFormat: string {
    case Year = 'y';
    case YearFraction = 'Y';
    case PlanetIndex = 'p';
    case PlanetName = 'P';
    case JulianDateTimeFormat = 'J';
    /**
     * Date formatted like 23.02.1992 (meaning the 23th 
     * of February, 1992).
     */
    case GregorianDateTimeFormat = 'T';
    /**
     * Date formatted like 920223 (meaning the 23th of 
     * February, 1992).
     */
    case IntegerDateFormat = 't';
    /**
     * Longitude formatted as degrees, minutes and seconds.
     */
    case LongitudeDegree = 'L';
    /**
     * Longitude formatted as decimal degrees.
     */
    case LongitudeDecimal = 'l';
    /**
     * Longitude formatted in degrees, minutes and seconds, 
     * East of Greenwich (with a minus sign) or West of 
     * Greenwich (with a plus sign).
     */
    case RelativeLongitudeDegree = 'Z';
    /**
     * The longitudinal speed in degrees, minutes and seconds
     * per day.
     */
    case DailyLongitudinalSpeedDegree = 'S';
    /**
     * The longitudinal speed in decimals per day.
     */
    case DailyLongitudinalSpeedDecimal = 's';
    /**
     * Latitude formatted as degrees, minutes and seconds.
     */
    case LatitudeDegree = 'B';
    /**
     * Latitude formatted as decimal degrees.
     */
    case LatitudeDecimal = 'b';
    /**
     * The decimal distance in Astronomical Units.
     */
    case DistanceAU = 'R';
    /**
     * The decimal distance in light years.
     */
    case DistanceLightYears = 'W';
    /**
     * The decimal distance in kilometers.
     */
    case DistanceKilometers = 'w';
    /**
     * The declination in degrees.
     */
    case DeclinationDegree = 'D';
    /**
     * The declination in decimals.
     */
    case DeclinationDecimal = 'd';
    /**
     * The Azimuth in degrees.
     */
    case AzimuthDegree = 'I';
    /**
     * The Azimuth in decimals.
     */
    case AzimuthDecimal = 'i';
    /**
     * The altitude in degrees.
     */
    case AltitudeDegree = 'H';
    /**
     * The altitude in decimals.
     */
    case AltitudeDecimals = 'h';
    case RightAscensionDegree = 'A';
    case RightAscensionHoursDecimal = 'a';
    case HousePositionDegree = 'G';
    case HousePositionDegreeDecimals = 'g';
    case HouseNumber = 'j';
    case EclipticalCoordinates = 'X';
    case EquatorialCoordinates = 'x';
    case MeanNodes = 'n';
    case OsculatingNodes = 'N';
    case MeanApsides = 'f';
    case OsculatingApsides = 'F';
    case PhaseAngle = '+';
    case Phase = '-';
    case Elongation = '*';
    case AppearentDiscDiameter = '/';
    case Magnitude = '=';
}