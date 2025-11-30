<?php
namespace MarcoConsiglio\Ephemeris\Templates\Moon;

use MarcoConsiglio\Ephemeris\Command\SwissEphemerisArgument;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisFlag;
use MarcoConsiglio\Ephemeris\Enums\CommandFlag;
use MarcoConsiglio\Ephemeris\Enums\OutputFormat;
use MarcoConsiglio\Ephemeris\Enums\SinglePlanet;
use MarcoConsiglio\Ephemeris\Enums\TimeSteps;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromRecords;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Templates\QueryTemplate;

/**
 * A template for an ephemeris query to obtain 
 * the synodic rhythm of the Moon.
 */
class SynodicRhythmTemplate extends QueryTemplate
{
    /**
     * The column names to be given to the columns of 
     * the ephemeris response.
     *
     * @var array
     */
    protected static array $columns = [
        0 => "timestamp",
        1 => "angular_distance",
        2 => "daily_speed"
    ];

    /**
     * The output format of the ephemeris.
     * 
     * Warning! Changing the output format will cause errors in getMoonSynodicRhythm() method.
     *
     * @var string
     */
    protected string $output_format = 
        OutputFormat::GregorianDateTimeFormat->value.
        OutputFormat::LongitudeDecimal->value.
        OutputFormat::DailyLongitudinalSpeedDecimal->value;

    /**
     * The object that will be built with the requested 
     * ephemeris.
     *
     * @var SynodicRhythm
     */
    protected SynodicRhythm $object;

    /**
     * Prepares arguments for the swetest executable.
     *
     * @codeCoverageIgnore
     * @return void
     */
    protected function prepareArguments(): void {}

    /**
     * Prepares flags for the swetest executable.
     *
     * @return void
     */
    protected function prepareFlags(): void
    {
        $this->command->addFlag(new SwissEphemerisFlag(CommandFlag::ObjectSelection->value, SinglePlanet::Moon->value));
        $this->command->addFlag(new SwissEphemerisFlag(CommandFlag::DifferentialObjectSelection->value, SinglePlanet::Sun->value));
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
     * Parse a line of the raw ephemeris output.
     * 
     * @return array|null
     */
    protected function parse(string $text): array|null
    {
        if (
            $this->datetimeFound($text, $datetime) &&
            $this->decimalNumberFound($text, $decimal)
        ) return [$datetime[0], $decimal[0], $decimal[1]];
        else return null;
    }

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
     * It constructs the SynodicRhythm collection.
     *
     * @return void
     */
    protected function buildObject(): void
    {
        $this->object = new SynodicRhythm(
            new FromArray($this->output->all()), 
            $this->step_size
        );           
    }

    /**
     * Returns the builded object.
     *
     * @return SynodicRhythm
     */
    protected function fetchObject(): SynodicRhythm
    {
        return $this->object;
    }

    /**
     * Gets the builded SynodicRhythm collection.
     *
     * @return SynodicRhythm
     */
    public function getResult(): SynodicRhythm
    {
        if (!$this->completed) $this->query();
        return $this->fetchObject();
    }

    /**
     * It returns the columns names used by this template.
     */
    static public function getColumns(): array
    {
        return self::$columns;
    }
}