<?php
namespace MarcoConsiglio\Ephemeris\Observer;

use AdamBrett\ShellWrapper\Command;

class Geocentric extends PointOfView
{
    protected function acceptPointOfView(Command &$command)
    {
        // Do nothing.
    }
}