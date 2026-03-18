<?php
namespace MarcoConsiglio\Ephemeris\Templates\Moon;

use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Templates\QueryTemplate;

/**
 * The template for an ephemeris query to obtain 
 * the Moon AnomalisticRhythm collection.
 */
abstract class AnomalisticTemplate extends QueryTemplate
{
    /**
     * The query start date.
     *
     * @var SwissEphemerisDateTime
     */
    protected SwissEphemerisDateTime $start_date;

    /**
     * The column names to be given to the columns of 
     * the ephemeris response.
     *
     * @var array
     */
    protected static array $columns = [
        0 => "astral_object",
        1 => "timestamp",
        2 => "longitude",
        3 => "daily_speed"
    ];

    /**
     * Remap the output in an associative array,
     * with the columns name as the key.
     *
     * @codeCoverageIgnore
     */
    abstract protected function remapColumns(): void;

    /**
     * Formats the output before parsing it, if necessary.
     *
     * @codeCoverageIgnore
     */
    protected function formatHook(): void {}


    /**
     * Return the columns names used by this template.
     */
    static public function getColumns(): array
    {
        return static::$columns;
    }

    protected function setFlags(): void
    {
        // Only the geocentric point of view is acceptable, so no other
        // point view will be accepted.
        $this->pov->setPointOfView($this->command, fn() => false);
    }
}