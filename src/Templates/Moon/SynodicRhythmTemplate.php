<?php
namespace MarcoConsiglio\Ephemeris\Templates\Moon;

use MarcoConsiglio\Ephemeris\Command\SwissEphemerisArgument;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisFlag;
use MarcoConsiglio\Ephemeris\Enums\CommandFlag;
use MarcoConsiglio\Ephemeris\Enums\OutputFormat;
use MarcoConsiglio\Ephemeris\Enums\SinglePlanet;
use MarcoConsiglio\Ephemeris\Enums\TimeSteps;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromArray;
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
     * the ephemeris answer.
     *
     * @var array
     */
    protected array $columns = [
        0 => "timestamp",
        1 => "angular_distance"
    ];

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
    protected function prepareArguments(): void
    {

    }

    /**
    /**
     * Prepares flags for the swetest executable.
     *
     * @return void
     */
    protected function prepareFlags(): void
    {
        $start_date = SwissEphemerisDateTime::create($this->start_date);
        $steps = $this->getStepsNumber();
        // Warning! Changing the object format will cause errors in getMoonSynodicRhythm() method.
        $object_format = OutputFormat::GregorianDateTimeFormat->value.OutputFormat::LongitudeDecimal->value;
        $this->command->addFlag(new SwissEphemerisFlag(CommandFlag::ObjectSelection->value, SinglePlanet::Moon->value));
        $this->command->addFlag(new SwissEphemerisFlag(CommandFlag::DifferentialObjectSelection->value, SinglePlanet::Sun->value));
        $this->command->addFlag(new SwissEphemerisFlag(CommandFlag::BeginDate->value, $start_date->toGregorianDate()));
        $this->command->addFlag(new SwissEphemerisFlag(CommandFlag::InputTerrestrialTime->value, $start_date->toTimeString()));
        $this->command->addFlag(new SwissEphemerisFlag(CommandFlag::StepsNumber->value, $steps));
        $this->command->addFlag(new SwissEphemerisFlag(CommandFlag::TimeSteps->value, $this->step_size.TimeSteps::MinuteSteps->value));
        $this->command->addFlag(new SwissEphemerisFlag(CommandFlag::ResponseFormat->value, $object_format));       
    }

    /**
     * Sets whether or not the header appears in the 
     * ephemeris response.
     *
     * @return void
     */
    protected function setHeader(): void
    {
        // No header.
        $this->command->addArgument(new SwissEphemerisArgument(CommandFlag::NoHeader->value));
    }

    /**
     * Parse the response.
     *
     * @return void
     */
    protected function parseOutput(): void
    {
        $this->output->transform(function($row) {
            return $this->parse($row);
        });
    }

    /**
     * Parse a line of the raw ephemeris output.
     * 
     * @return array|null
     */
    protected function parse(string $text): array|null
    {
        if (
            $this->datetimeFound($text, $datetime) &&
            $this->decimalNumberFound($text, $decimal_number)
        ) return [$datetime[0], $decimal_number[0]];
        else return null;
    }

    /**
     * Remap the output in an associative array,
     * with the columns name as the key.
     *
     * @return void
     */
    protected function remapColumns(): void
    {
        $this->remapColumnsBy($this->columns);           
    }

    /**
     * Constructs the SynodicRhythm collection.
     *
     * @return void
     */
    protected function buildObject(): void
    {
        $this->object = new SynodicRhythm(new FromArray($this->output->all()));           
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
}