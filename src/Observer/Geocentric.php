<?php
namespace MarcoConsiglio\Ephemeris\Observer;

use AdamBrett\ShellWrapper\Command;

/**
 * The class responsible to set the geocentric point of view
 * on the Swiss Ephemeris command.
 * 
 * The geocentric point of view is the default POV and the
 * command doesn't need a flag to be set.
 * 
 * @codeCoverageIgnore is this class really useful?
 */
class Geocentric extends PointOfView
{
    /**
     * Set the viewpoint in the $command.
     * 
     * This method actually do nothing at all.
     *
     * @param Command $command
     * @return void
     */
    protected function acceptPointOfView(Command &$command)
    {
        // Do nothing.
    }
}