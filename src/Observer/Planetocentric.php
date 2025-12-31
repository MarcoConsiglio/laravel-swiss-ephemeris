<?php
namespace MarcoConsiglio\Ephemeris\Observer;

use AdamBrett\ShellWrapper\Command;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisFlag;
use MarcoConsiglio\Ephemeris\Enums\ObserverPosition;
use MarcoConsiglio\Ephemeris\Enums\SinglePlanet;

/**
 * The class responsible to set the planetocentric point of view
 * on the Swiss Ephemeris command.
 */
class Planetocentric extends PointOfView
{
    /**
     * The planet at the center of which the observer is located.
     *
     * @var SinglePlanet
     */
    public SinglePlanet $planet;

    /**
     * Constructss the point of view from the center of the $planet.
     *
     * @param SinglePlanet $planet
     */
    public function __construct(SinglePlanet $planet)
    {
        $this->planet = $planet;
    }

    /**
     * Set the viewpoint in the $command.
     *
     * @param Command $command
     * @return void
     */
    protected function acceptPointOfView(Command &$command)
    {
        $command->addFlag(new SwissEphemerisFlag(ObserverPosition::Planetocentric->value, 
            $this->planet->value
        ));
    }
}