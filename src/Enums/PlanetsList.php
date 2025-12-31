<?php
namespace MarcoConsiglio\Ephemeris\Enums;

/**
 * Represents a shortcut flag to select a group of stellar objects.
 * 
 * The Swiss Ephemeris encodes planets and other objects with 
 * alphanumeric codes. This is a list of codes that are passed 
 * to the executable to refer to a collection of stellar object.
 * 
 * @codeCoverageIgnore
 */
enum PlanetsList: String {
    /**
     * Refers to Sun, Moon, Mercury, Venus, Mars, Jupiter,
     * Saturn, Uranus, Neptune, Pluto, mean lunar node, true 
     * lunar node, mean lunar apogee (or Lilith/Black Moon),
     * osculating lunar apogee, Earth (in heliocentric or 
     * barycentric calculation) 
     */
    case Default = 'd';

    /**
     * Refers to the main factors as PlanetList::Default plus
     * the asteroids/dwarf planets Chiron, Pholus, Pallas, Juno,
     * Vesta,
     */
    case DefaultPlusMainAsteroids = 'p';

    /**
     * Refers to the fictious planets Cupido, Hades, Zeus,
     * Kronos, Apollon, Admetos, Vulkanus, Poseidon, Isis,
     * Nibiru, Harrington, Leverrier's Neptune, Adams' Neptune,
     * Lowell's Pluto, Pickering's Pluto.
     */
    case FictiousPlanets = 'h';
}