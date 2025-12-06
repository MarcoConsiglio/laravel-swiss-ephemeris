<?php
namespace MarcoConsiglio\Ephemeris\Templates\Moon;

use MarcoConsiglio\Ephemeris\Command\SwissEphemerisArgument as Argument;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisFlag as Flag;
use MarcoConsiglio\Ephemeris\Enums\CommandFlag;
use MarcoConsiglio\Ephemeris\Enums\OutputFormat;
use MarcoConsiglio\Ephemeris\Enums\RegExPattern;
use MarcoConsiglio\Ephemeris\Enums\SinglePlanet;
use MarcoConsiglio\Ephemeris\Enums\TimeSteps;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Perigees\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Perigees;

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
     * The output format of the ephemeris.
     * 
     * Warning! Changing the output format will cause errors in getMoonAnomalisticRhythm() method.
     *
     * @var string
     */
    protected string $output_format = 
        OutputFormat::PlanetName->value.
        OutputFormat::GregorianDateTimeFormat->value.
        OutputFormat::LongitudeDecimal->value.
        OutputFormat::DailyLongitudinalSpeedDecimal->value;

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
        $this->command->addFlag(new Flag(CommandFlag::ObjectSelection->value, SinglePlanet::Moon->value.SinglePlanet::LunarPerigee->value));
        $this->command->addFlag(new Flag(CommandFlag::ResponseFormat->value, $this->output_format));
    }

    /**
     * It parses a line of the raw ephemeris output.
     * 
     * @return array|null
     */
    protected function parse(string $text): array|null
    {
        $object_name_regex = RegExPattern::getRegex(RegExPattern::Moon."|".RegExPattern::InterpolatedPerigee);
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
     * It constructs the Perigees collection.
     *
     * @return void
     */
    protected function buildObject(): void
    {
        $this->object = new Perigees(new FromArray($this->output->all(), $this->step_size));
    }

    /**
     * It returns the builded object.
     *
     * @return Perigees
     */
    protected function fetchObject(): Perigees
    {
        return $this->object;
    }

    /**
     * It returns the builded Perigees collection.
     *
     * @return Perigees
     */
    public function getResult(): Perigees
    {
        if (!$this->completed) $this->query();
        return $this->fetchObject();
    }

    /**
     * It remaps the output in an associative array, 
     * with the columns name as the key.
     *
     * @return void
     */
    protected function remapColumns(): void
    {
        $this->remapColumnsBy($this->getColumns());
    }
}