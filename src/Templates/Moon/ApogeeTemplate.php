<?php
namespace MarcoConsiglio\Ephemeris\Templates\Moon;

use MarcoConsiglio\Ephemeris\Command\SwissEphemerisArgument as Argument;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisFlag as Flag;
use MarcoConsiglio\Ephemeris\Enums\CommandFlag;
use MarcoConsiglio\Ephemeris\Enums\OutputFormat;
use MarcoConsiglio\Ephemeris\Enums\RegExPattern;
use MarcoConsiglio\Ephemeris\Enums\SinglePlanet;
use MarcoConsiglio\Ephemeris\Enums\TimeSteps;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Apogees\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Apogees;

/**
 * The template for an ephemeris query to obtain 
 * the Moon Apogees collection.
 */
class ApogeeTemplate extends AnomalisticTemplate
{
    /**
     * The astral_object that will be built with the requested 
     * ephemeris.
     *
     * @var Apogees
     */
    protected Apogees $object;

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
        $steps = $this->getStepsNumber();
        $this->command->addFlag(new Flag(CommandFlag::BeginDate->value, $this->start_date->toGregorianDate()));
        $this->command->addFlag(new Flag(CommandFlag::StepsNumber->value, $steps));
        $this->command->addFlag(new Flag(CommandFlag::TimeSteps->value, $this->step_size.TimeSteps::MinuteSteps->value));
        $this->command->addFlag(new Flag(CommandFlag::InputTerrestrialTime->value, $this->start_date->toTimeString()));
        $this->command->addFlag(new Flag(CommandFlag::ObjectSelection->value, SinglePlanet::Moon->value.SinglePlanet::LunarApogee->value));
        // Warning! Changing the output format will cause errors in getMoonAnomalisticRhythm() method.
        $object_format = OutputFormat::PlanetName->value.OutputFormat::GregorianDateTimeFormat->value.OutputFormat::LongitudeDegree->value;
        $this->command->addFlag(new Flag(CommandFlag::ResponseFormat->value, $object_format));
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
        $this->command->addArgument(new Argument(CommandFlag::NoHeader->value));
    }
    
    /**
     * It formats the output before parsing it, if necessary.
     *
     * @return void
     */
    protected function formatHook(): void
    {
        // The output miss seconds sign.
        $this->output->transform(function($row) {
            return $row."\"";
        });
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
        $object_name_regex = RegExPattern::getRegex(RegExPattern::Moon."|".RegExPattern::InterpolatedApogee);
        if (
            $this->astralObjectFound($text, $object_name_regex, $astral_object) &&
            $this->datetimeFound($text, $datetime) &&
            $this->angularValuesFound($text, $angle)
        ) return [$astral_object[0], $datetime[0], $angle];
        else return null;
    }

    /**
     * It constructs the Apogee collection.
     *
     * @return void
     */
    protected function buildObject(): void
    {
        $this->object = new Apogees(new FromArray($this->output->all()));
    }

    /**
     * Returns the builded object.
     *
     * @return Apogees
     */
    protected function fetchObject(): Apogees
    {
        return $this->object;
    }

    /**
     * Gets the builded SynodicRhythm collection.
     *
     * @return Apogees
     */
    public function getResult(): Apogees
    {
        if (!$this->completed) $this->query();
        return $this->fetchObject();
    }
}