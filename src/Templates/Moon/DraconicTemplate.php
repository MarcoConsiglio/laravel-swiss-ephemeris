<?php
namespace MarcoConsiglio\Ephemeris\Templates\Moon;

use MarcoConsiglio\Ephemeris\Command\SwissEphemerisFlag;
use MarcoConsiglio\Ephemeris\Enums\CommandFlag;
use MarcoConsiglio\Ephemeris\Enums\OutputFormat;
use MarcoConsiglio\Ephemeris\Enums\SinglePlanet;
use MarcoConsiglio\Ephemeris\Enums\TimeSteps;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\DraconicRhythm;
use MarcoConsiglio\Ephemeris\Templates\QueryTemplate;

/**
 * A template for an ephemeris query to obtain 
 * the draconic rhythm of the Moon.
 */
class DraconicTemplate extends QueryTemplate
{
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
        3 => "latitude",
        4 => "daily_speed"
    ];

    protected string $output_format = 
        OutputFormat::PlanetIndex->value.
        OutputFormat::GregorianDateTimeFormat->value.
        OutputFormat::LongitudeDecimal->value.
        OutputFormat::LatitudeDecimal->value.
        OutputFormat::DailyLongitudinalSpeedDecimal->value;

    /**
     * The object that will be built with the requested 
     * ephemeris.
     *
     * @var DraconicRhythm
     */
    protected DraconicRhythm $object;

    /**
     * Prepares arguments for the swetest executable.
     *
     * @codeCoverageIgnore
     * @return void
     */
    protected function prepareArguments(): void {}

    /**
    /**
     * Prepares flags for the swetest executable.
     *
     * @return void
     */
    protected function prepareFlags(): void
    {
        $this->command->addFlag(new SwissEphemerisFlag(
            CommandFlag::ObjectSelection->value, 
            SinglePlanet::Moon->value.SinglePlanet::TrueLunarNode->value
        ));
        $this->command->addFlag(new SwissEphemerisFlag(CommandFlag::ResponseFormat->value, $this->output_format));       
    }

    /**
     * It formats the output before parsing it, if necessary.
     *
     * @return void
     * @codeCoverageIgnore
     */
    protected function formatHook(): void {}

    /**
     * Remap the output in an associative array,
     * with the columns name as keys.
     *
     * @return void
     * @codeCoverageIgnore
     */
    protected function remapColumns(): void
    {
        $this->remapColumnsBy($this->getColumns());    
    }
}