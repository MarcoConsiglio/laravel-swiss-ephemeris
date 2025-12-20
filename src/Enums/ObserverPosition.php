<?php
namespace MarcoConsiglio\Ephemeris\Enums;

/**
 * Flags that specify the position of the observer.
 * 
 * @codeCoverageIgnore
 */
enum ObserverPosition: string
{
    case Heliocentric = "hel";
    case Baricentric = "bary";
    case Topocentric = "topo";
    case Planetocentric = "pc";
}