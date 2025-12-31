<?php
namespace MarcoConsiglio\Ephemeris\Observer;

use AdamBrett\ShellWrapper\Command;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisFlag;
use MarcoConsiglio\Ephemeris\Enums\ObserverPosition;
use MarcoConsiglio\Ephemeris\Enums\SinglePlanet;

class Planetocentric extends PointOfView
{
    public SinglePlanet $planet;

    public function __construct(SinglePlanet $planet)
    {
        $this->planet = $planet;
    }

    protected function acceptPointOfView(Command &$command)
    {
        $command->addFlag(new SwissEphemerisFlag(ObserverPosition::Planetocentric->value, 
            $this->planet->value
        ));
    }
}