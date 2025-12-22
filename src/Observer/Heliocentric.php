<?php
namespace MarcoConsiglio\Ephemeris\Observer;

use AdamBrett\ShellWrapper\Command;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisFlag;
use MarcoConsiglio\Ephemeris\Enums\ObserverPosition;

class Heliocentric extends PointOfView
{
    protected function acceptPointOfView(Command &$command)
    {
        $command->addFlag(new SwissEphemerisFlag(ObserverPosition::Heliocentric->value));
    }
}