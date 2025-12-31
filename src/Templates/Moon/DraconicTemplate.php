<?php
namespace MarcoConsiglio\Ephemeris\Templates\Moon;

use MarcoConsiglio\Ephemeris\Command\SwissEphemerisFlag;
use MarcoConsiglio\Ephemeris\Enums\CommandFlag;
use MarcoConsiglio\Ephemeris\Enums\OutputFormat;
use MarcoConsiglio\Ephemeris\Enums\SinglePlanet;
use MarcoConsiglio\Ephemeris\Parsers\Strategies\Moon\Node as NodeParser;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\DraconicRhythm\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\DraconicRhythm;
use MarcoConsiglio\Ephemeris\Templates\QueryTemplate;

/**
 * The template for an ephemeris query to obtain 
 * the Moon DraconicRhythm.
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
        3 => "daily_speed"
    ];

    /**
     * The output format of the ephemeris.
     * 
     * Warning! Changing the output format will cause errors in getMoonDraconicRhythm() method.
     *
     * @var string
     */
    protected string $output_format = 
        OutputFormat::PlanetName->value.
        OutputFormat::GregorianDateTimeFormat->value.
        OutputFormat::LongitudeDecimal->value.
        OutputFormat::DailyLongitudinalSpeedDecimal->value;

    /**
     * The object that will be built with the requested 
     * ephemeris.
     *
     * @var DraconicRhythm
     */
    protected DraconicRhythm $object;

    /**
     * Set arguments for the swetest executable.
     *
     * @codeCoverageIgnore
     */
    protected function setArguments(): void {}

    /**
     * Set flags for the swetest executable.
     */
    protected function setFlags(): void
    {
        $this->command->addFlag(new SwissEphemerisFlag(
            CommandFlag::ObjectSelection->value, 
            SinglePlanet::Moon->value.SinglePlanet::TrueLunarNode->value
        ));
        $this->command->addFlag(new SwissEphemerisFlag(CommandFlag::ResponseFormat->value, $this->output_format));       
        // Only the geocentric point of view is acceptable, so no other
        // point view will be accepted.
        $this->pov->setPointOfView($this->command, fn() => false);
    }

    /**
     * Parse a line of the raw ephemeris output.
     */
    protected function parse(string $text): array|null
    {
        return new NodeParser($text)->found();
    }

    /**
     * Construct the DraconicRhythm object.
     */
    protected function buildObject(): void
    {
        $this->object = new DraconicRhythm(
            new FromArray($this->output->all(), $this->step_size)
        );
    }

    /**
     * Formats the output before parsing it, if necessary.
     *
     * @codeCoverageIgnore
     */
    protected function formatHook(): void {}

    /**
     * Remap the output in an associative array,
     * with the columns name as keys.
     *
     * @codeCoverageIgnore
     */
    protected function remapColumns(): void
    {
        $this->remapColumnsBy(static::getColumns());    
    }

    /**
     * Return the columns names used by this template.
     */
    public static function getColumns(): array
    {
        return static::$columns;
    }

    /**
     * Return the DraconicRhythm collection.
     */
    public function getResult(): DraconicRhythm
    {
        return parent::getResult();
    }

    /**
     * Return the builded object.
     */
    protected function fetchObject(): DraconicRhythm
    {
        return $this->object;
    }
}