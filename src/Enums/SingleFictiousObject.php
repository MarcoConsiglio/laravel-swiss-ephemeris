<?php
namespace MarcoConsiglio\Ephemeris\Enums;

/**
 * The Swiss Ephemeris encodes planets and other objects with 
 * alphanumeric codes. This is a list of codes that are passed 
 * to the executable to refer to a single stellar object.
 * 
 * @codeCoverageIgnore
 */
enum SingleFictiousObject: String {
    case Cupido = 'J';
    case Hades = 'K';
    case Zeus = 'L';
    case Kronos = 'M';
    case Apollon = 'N';
    case Admetos = 'O';
    case Vulkanus = 'P';
    case Poseidon = 'Q';
    case Isis = 'R';
    case Nibiru = 'S';
    case Harrington = 'T';
    case LeverrierNeptune = 'U';
    case AdamNeptune = 'V';
    case LowellPluto = 'W';
    case PickeringPluto = 'X';
    case Vulcan = 'Y';
    case WhiteMoon = 'Z';
}