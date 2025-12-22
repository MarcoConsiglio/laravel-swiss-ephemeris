<?php
namespace MarcoConsiglio\Ephemeris\Observer;

use AdamBrett\ShellWrapper\Command;

/**
 * The observer point of view Strategy tells the concrete QueryTemplate how
 * to set a point of view to query the Swiss Ephemeris. 
 */
interface Strategy
{
    /**
     * Sets the point of view for the `swetest` executable.
     *
     * @param Command $command The command to be executed by a concrete QueryTemplate.
     * @param callable $validity The callback the concrete QueryTemplate use to tell the
     * observer strategy if the strategy is acceptable.
     * @return void
     */
    public function setPointOfView(Command &$command, callable $is_valid): void;
}