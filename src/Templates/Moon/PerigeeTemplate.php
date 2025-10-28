<?php
namespace MarcoConsiglio\Ephemeris\Templates\Moon;

use MarcoConsiglio\Ephemeris\Command\SwissEphemerisArgument as Argument;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisFlag as Flag;
use MarcoConsiglio\Ephemeris\Enums\CommandFlag;
use MarcoConsiglio\Ephemeris\Enums\OutputFormat;
use MarcoConsiglio\Ephemeris\Enums\RegExPattern;
use MarcoConsiglio\Ephemeris\Enums\SinglePlanet;
use MarcoConsiglio\Ephemeris\Enums\TimeSteps;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Perigees\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Perigees;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;

/**
 * The template for an ephemeris query to obtain 
 * the Moon Perigees collection.
 */
class PerigeeTemplate extends AnomalisticTemplate
{
    /**
     * The astral_object that will be built with the requested 
     * ephemeris.
     *
     * @var Perigees
     */
    protected Perigees $object;

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
        $this->command->addFlag(new Flag(CommandFlag::ObjectSelection->value, SinglePlanet::Moon->value.SinglePlanet::LunarPerigee->value));
        // Warning! Changing the output format will cause errors in getMoonAnomalisticRhythm() method.
        $object_format = OutputFormat::PlanetName->value.OutputFormat::GregorianDateTimeFormat->value.OutputFormat::LongitudeDecimal->value;
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
     * Parse the response.
     *
     * @return void
     */
    protected function parseOutput(): void
    {
        foreach ($this->output as $index => $row) {
            $astral_object = '';
            $datetime = '';
            $decimal_number = 0.0;
            $row_name_regex = RegExPattern::getObjectNamesRegex(RegExPattern::Moon."|".RegExPattern::InterpolatedPerigee);
            preg_match($row_name_regex, $row, $astral_object);
            preg_match(RegExPattern::UniversalAndTerrestrialDateTime->value, $row, $datetime);
            preg_match(RegExPattern::RelativeDecimalNumber->value, $row, $decimal_number);
            $this->output[$index] = [$astral_object[0], $datetime[0], $decimal_number[0]];
        }       
    }

    /**
     * Constructs the Apogee collection.
     *
     * @return void
     */
    protected function buildObject(): void
    {
        $this->object = new Perigees(new FromArray($this->output));
    }

    /**
     * Gets the builded SynodicRhythm collection.
     *
     * @return Perigees
     */
    public function getResult(): Perigees
    {
        if (!$this->completed) $this->query();
        return $this->object;
    }
}