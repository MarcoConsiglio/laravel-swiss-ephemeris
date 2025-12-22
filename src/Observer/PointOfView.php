<?php
namespace MarcoConsiglio\Ephemeris\Observer;

use AdamBrett\ShellWrapper\Command;
use MarcoConsiglio\Ephemeris\Observer\Strategy as ObserverStrategy;

abstract class PointOfView implements ObserverStrategy
{
    public function setPointOfView(Command &$command, callable $is_valid): void
    {
        if ($is_valid()) $this->acceptPointOfView($command);
    }

    abstract protected function acceptPointOfView(Command &$command);
}