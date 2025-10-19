<?php
namespace MarcoConsiglio\Ephemeris\Command;

use AdamBrett\ShellWrapper\Command\Argument;

/**
 * Represents an argument passed to the Swiss Ephemeris executable.
 */
class SwissEphemerisArgument extends Argument
{
    public const PREFIX = '-';
}