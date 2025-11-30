<?php
namespace MarcoConsiglio\Ephemeris\Enums;

/**
 * The Swiss Ephemeris encodes planets and other objects with 
 * alphanumeric codes. This is a list of codes that are passed 
 * to the executable to refer to a single planet.
 */
enum SinglePlanet: string {
    case Sun = '0';
    case Moon = '1';
    case Mercury = '2';
    case Venus = '3';
    case Mars = '4';
    case Jupiter = '5';
    case Saturn = '6';
    case Uranus = '7';
    case Neptune = '8';
    case Pluto = '9';
    case Earth = 'C';
    case MeanLunarApogee = "A";
    case OsculatingLunarApogee = "B";
    case InterpolatedLunarApogee = 'c';
    case InterpolatedLunarPerigee = 'g';
    case MeanLunarNode = 'm';
    case TrueLunarNode = 't';
    public const Lilith = self::MeanLunarApogee;
    public const BlackMoon = self::MeanLunarApogee;
    public const TrueLilith = self::OsculatingLunarApogee;
    public const NaturalLunarApogee = self::InterpolatedLunarApogee;
    public const LunarApogee = self::InterpolatedLunarApogee;
    public const NaturalLunarPerigee = self::InterpolatedLunarPerigee;
    public const LunarPerigee = self::InterpolatedLunarPerigee;
}