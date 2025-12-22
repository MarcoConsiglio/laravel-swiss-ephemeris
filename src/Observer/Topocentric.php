<?php
namespace MarcoConsiglio\Ephemeris\Observer;

use AdamBrett\ShellWrapper\Command;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisFlag;
use MarcoConsiglio\Ephemeris\Enums\ObserverPosition;

/**
 * The locale variables for a topocentric point of view.
 */
class Topocentric extends PointOfView
{
    /**
     * The longitude of the topocentric POV expressed in decimal degrees.
     * 
     * @var float
     */
    public protected(set) float $longitude;

    /**
     * The latitude of the topocentric POV expressed in decimal degrees.
     * 
     * @var float
     */
    public protected(set) float $latitude;

    /**
     * The altitude of the topocentric POV expressed in meters.
     * 
     * @var int
     */
    public protected(set) int $altitude;

    /**
     * Constructs the TopcocentricLocale.
     * 
     * The default values are pointing to the Greenwich Royal Observatory.
     *
     * @param float $latitude   The latitude expressed in decimal degrees.
     * @param float $longitude  The longitude expressed in decimal degrees.
     * @param integer $altitude The altitude expressed in meters.
     */
    public function __construct(float $latitude = 51.5, float $longitude = 0.0, int $altitude = 0)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->altitude = $altitude;
    }

    protected function acceptPointOfView(Command &$command)
    {
        $command->addFlag(new SwissEphemerisFlag(ObserverPosition::Topocentric->value, 
            "[{$this->longitude},{$this->latitude},{$this->altitude}]"
        ));
    }
}