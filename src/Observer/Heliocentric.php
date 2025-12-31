<?php
namespace MarcoConsiglio\Ephemeris\Observer;

use AdamBrett\ShellWrapper\Command;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisFlag;
use MarcoConsiglio\Ephemeris\Enums\ObserverPosition;

/**
 * The class responsible to set the heliocentric point of view
 * on the Swiss Ephemeris command.
 */
class Heliocentric extends PointOfView
{
    /**
     * Set the viewpoint in the $command.
     *
     * @param Command $command
     * @return void
     */
    protected function acceptPointOfView(Command &$command)
    {
        $command->addFlag(new SwissEphemerisFlag(ObserverPosition::Heliocentric->value));
    }
}