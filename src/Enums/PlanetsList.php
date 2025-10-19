<?php
namespace MarcoConsiglio\Ephemeris\Enums;

/**
 * The Swiss Ephemeris encodes planets and other objects with 
 * alphanumeric codes. This is a list of codes that are passed 
 * to the executable to refer to a collection of stellar object.
 */
enum PlanetsList: String {
    /**
     * It refers to Sun, Moon, Mercury, Venus, Mars, Jupiter,
     * Saturn, Uranus, Neptune, Pluto, mean lunar node, true 
     * lunar node, mean lunar apogee (or Lilith/Black Moon),
     * osculating lunar apogee, Earth (in heliocentric or 
     * barycentric calculation) 
     */
    case Default = 'd';

    /**
     * It refers to the main factors as PlanetList::Default plus
     * the asteroids/dwarf planets Chiron, Pholus, Pallas, Juno,
     * Vesta,
     */
    case DefaultPlusMainAsteroids = 'p';

    /**
     * It refers to the fictious planets Cupido, Hades, Zeus,
     * Kronos, Apollon, Admetos, Vulkanus, Poseidon, Isis,
     * Nibiru, Harrington, Leverrier's Neptune, Adams' Neptune,
     * Lowell's Pluto, Pickering's Pluto.
     */
    case FictiousPlanets = 'h';
}