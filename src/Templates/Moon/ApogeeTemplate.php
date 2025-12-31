<?php
namespace MarcoConsiglio\Ephemeris\Templates\Moon;

use MarcoConsiglio\Ephemeris\Command\SwissEphemerisFlag as Flag;
use MarcoConsiglio\Ephemeris\Enums\CommandFlag;
use MarcoConsiglio\Ephemeris\Enums\OutputFormat;
use MarcoConsiglio\Ephemeris\Enums\SinglePlanet;
use MarcoConsiglio\Ephemeris\Parsers\Strategies\Moon\Apogee as ApogeeParser;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Apogees\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Apogees;

/**
 * The template for an ephemeris query to obtain 
 * the Moon Apogees collection.
 */
class ApogeeTemplate extends AnomalisticTemplate
{
    
    /**
     * The astral object that will be built with the requested 
     * ephemeris.
    *
    * @var Apogees
    */
    protected Apogees $object;

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
     * Set arguments for the swetest executable.
     *
     * @codeCoverageIgnore
     */
    protected function setArguments(): void {}

    /**
     * Set flags for the swetest executable.
     */
    #[\Override]
    protected function setFlags(): void
    {
        $this->command->addFlag(new Flag(CommandFlag::ObjectSelection->value, SinglePlanet::Moon->value.SinglePlanet::LunarApogee->value));
        $this->command->addFlag(new Flag(CommandFlag::ResponseFormat->value, $this->output_format));
        parent::setFlags();
    }

    /**
     * Parse a line of the raw ephemeris output.
     */
    protected function parse(string $text): array|null
    {
        return new ApogeeParser($text)->found();
    }

    /**
     * Construct the Apogees collection.
     */
    protected function buildObject(): void
    {
        $this->object = new Apogees(new FromArray($this->output->all(), $this->step_size));
    }

    /**
     * Return the builded object.
     */
    protected function fetchObject(): Apogees
    {
        return $this->object;
    }

    /**
     * Return the builded Apogees collection.
     */
    public function getResult(): Apogees
    {
        return parent::getResult();
    }

    /**
     * Remap the output in an associative array,
     * with the columns name as the key.
     */
    protected function remapColumns(): void
    {
        $this->remapColumnsBy($this->getColumns());
    }
}