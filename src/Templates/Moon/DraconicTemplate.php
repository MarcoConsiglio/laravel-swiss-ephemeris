<?php
namespace MarcoConsiglio\Ephemeris\Templates\Moon;

use MarcoConsiglio\Ephemeris\Command\SwissEphemerisFlag;
use MarcoConsiglio\Ephemeris\Enums\CommandFlag;
use MarcoConsiglio\Ephemeris\Enums\OutputFormat;
use MarcoConsiglio\Ephemeris\Enums\RegExPattern;
use MarcoConsiglio\Ephemeris\Enums\SinglePlanet;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\DraconicRhythm;
use MarcoConsiglio\Ephemeris\Templates\QueryTemplate;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\DraconicRhythm\FromArray;

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
     * @return void
     */
    protected function setArguments(): void {}

    /**
     * Set flags for the swetest executable.
     *
     * @return void
     */
    protected function setFlags(): void
    {
        $this->command->addFlag(new SwissEphemerisFlag(
            CommandFlag::ObjectSelection->value, 
            SinglePlanet::Moon->value.SinglePlanet::TrueLunarNode->value
        ));
        $this->command->addFlag(new SwissEphemerisFlag(CommandFlag::ResponseFormat->value, $this->output_format));       
    }

    /**
     * Parse a line of the raw ephemeris output.
     * 
     * @return array|null
     */
    protected function parse(string $text): array|null
    {
        $object_name_regex = RegExPattern::getRegex(RegExPattern::Moon."|".RegExPattern::TrueNode);
        if (
            $this->astralObjectFound($text, $object_name_regex, $astral_object) &&
            $this->datetimeFound($text, $datetime) &&
            $this->decimalNumberFound($text, $decimal)
        ) return [
            $astral_object[0],  // Object name
            $datetime[0],       // Datetime
            $decimal[0],        // Object longitude
            $decimal[1]         // Object daily speed
        ];
        else return null;
    }

    /**
     * Construct the DraconicRhythm object.
     *
     * @return void
     */
    protected function buildObject(): void
    {
        $this->object = new DraconicRhythm(
            new FromArray($this->output->all(), $this->step_size)
        );
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

    /**
     * Return the columns names used by this template.
     *
     * @return array
     */
    public static function getColumns(): array
    {
        return static::$columns;
    }

    /**
     * Return the DraconicRhythm collection.
     *
     * @return DraconicRhythm
     */
    public function getResult(): DraconicRhythm
    {
        if (! $this->completed) $this->query();
        return $this->fetchObject();
    }

    /**
     * Return the builded object.
     *
     * @return DraconicRhythm
     */
    protected function fetchObject(): DraconicRhythm
    {
        return $this->object;
    }
}