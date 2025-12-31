<?php
namespace MarcoConsiglio\Ephemeris\Observer;

use AdamBrett\ShellWrapper\Command;
use MarcoConsiglio\Ephemeris\Observer\Strategy as ObserverStrategy;

/**
 * The point of view from which to obtain the ephemeris.
 */
abstract class PointOfView implements ObserverStrategy
{
    /**
     * Set the viewpoint in the command if it's an acceptable viewpoint for the
     * QueryTemplate.
     *
     * @param Command $command
     * @param callable $is_valid
     * @return void
     */
    public function setPointOfView(Command &$command, callable $is_valid): void
    {
        if ($is_valid()) $this->acceptPointOfView($command);
    }

    /**
     * Set the viewpoint in the $command.
     *
     * @param Command $command
     * @return void
     */
    abstract protected function acceptPointOfView(Command &$command);
}