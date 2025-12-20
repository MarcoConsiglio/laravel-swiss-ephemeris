<?php
namespace MarcoConsiglio\Ephemeris\Enums;

/**
 * Flags that specify the position of the observer.
 * 
 * @codeCoverageIgnore
 */
enum ObserverPosition: string
{
    /**
     * Observation from the POV of the Sun.
     */
    case Heliocentric = "hel";
    /**
     * Observation from the solar system baricenter, which is close to the Sun.
     */
    case Baricentric = "bary";
    /**
     * Observation from a specific point on the Earth surface.
     */
    case Topocentric = "topo";
    /**
     * Observation from the center of a solar system body.
     */
    case Planetocentric = "pc";
}