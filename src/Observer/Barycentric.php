<?php
namespace MarcoConsiglio\Ephemeris\Observer;

use AdamBrett\ShellWrapper\Command;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisFlag;
use MarcoConsiglio\Ephemeris\Enums\ObserverPosition;

/**
 * The class responsible to set the barycentric point of view
 * on the Swiss Ephemeris command.
 */
class Barycentric extends PointOfView
{
    /**
     * Set the viewpoint in the $command.
     *
     * @return void
     */
    protected function acceptPointOfView(Command &$command)
    {
        $command->addFlag(new SwissEphemerisFlag(ObserverPosition::Barycentric->value));
    }
}