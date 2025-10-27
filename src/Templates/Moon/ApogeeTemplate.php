<?php
namespace MarcoConsiglio\Ephemeris\Templates\Moon;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Runners\DryRunner;
use AdamBrett\ShellWrapper\Runners\Exec;
use AdamBrett\ShellWrapper\Runners\FakeRunner;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisArgument as Argument;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisFlag as Flag;
use MarcoConsiglio\Ephemeris\Enums\CommandFlag;
use MarcoConsiglio\Ephemeris\Enums\OutputFormat;
use MarcoConsiglio\Ephemeris\Enums\RegExPattern;
use MarcoConsiglio\Ephemeris\Enums\SinglePlanet;
use MarcoConsiglio\Ephemeris\Enums\TimeSteps;
use MarcoConsiglio\Ephemeris\LaravelSwissEphemeris;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Apogees\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Apogees;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Templates\QueryTemplate;

/**
 * The template for an ephemeris query to obtain 
 * the Moon Apogees collection.
 */
class ApogeeTemplate extends QueryTemplate
{
    /**
     * The query start date.
     *
     * @var SwissEphemerisDateTime
     */
    protected SwissEphemerisDateTime $start_date;

    /**
     * The column names to be given to the columns of 
     * the ephemeris answer.
     *
     * @var array
     */
    protected array $columns = [
        0 => "astral_object",
        1 => "timestamp",
        2 => "longitude"
    ];

    /**
     * The astral_object that will be built with the requested 
     * ephemeris.
     *
     * @var Apogees
     */
    protected Apogees $object;

    /**
     * Construct the template in order to produce
     * a Moon AnomalisticRhythm.
     *
     * @param SwissEphemerisDateTime $start_date
     * @param integer $days
     * @param integer $step_size
     * @param Exec|DryRunner|FakeRunner|null|null $shell
     * @param Command|null $command
     */
    public function __construct(
        SwissEphemerisDateTime $start_date,
        int $days = 30,
        int $step_size = 60,
        Exec|DryRunner|FakeRunner|null $shell = null, 
        ?Command $command = null
    ) {
        $this->shell = $shell ?? new Exec();
        $this->command = $command ?? new Command(
            resource_path(LaravelSwissEphemeris::SWISS_EPHEMERIS_PATH) . 
            DIRECTORY_SEPARATOR . 
            LaravelSwissEphemeris::SWISS_EPHEMERIS_EXECUTABLE
        );     
        $this->start_date = $start_date;
        $this->days = $days;
        $this->step_size = $step_size;         
    }

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
        if (! $this->start_date instanceof SwissEphemerisDateTime) {
            $start_date = SwissEphemerisDateTime::create($this->start_date);
        } else $start_date = $this->start_date;
        $steps = $this->getStepsNumber();
        $this->command->addFlag(new Flag(CommandFlag::BeginDate->value, $start_date->toGregorianDate()));
        $this->command->addFlag(new Flag(CommandFlag::StepsNumber->value, $steps));
        $this->command->addFlag(new Flag(CommandFlag::TimeSteps->value, $this->step_size.TimeSteps::MinuteSteps->value));
        $this->command->addFlag(new Flag(CommandFlag::InputTerrestrialTime->value, $start_date->toTimeString()));
        $this->command->addFlag(new Flag(CommandFlag::ObjectSelection->value, SinglePlanet::Moon->value.SinglePlanet::InterpolatedLunarApogee->value));
        // Warning! Changing the astral_object format will cause errors in getMoonAnomalisticRhythm() method.
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
            $row_name_regex = RegExPattern::getObjectNamesRegex(RegExPattern::Moon."|".RegExPattern::InterpolatedApogee);
            preg_match($row_name_regex, $row, $astral_object);
            preg_match(RegExPattern::UniversalAndTerrestrialDateTime->value, $row, $datetime);
            preg_match(RegExPattern::RelativeDecimalNumber->value, $row, $decimal_number);
            $this->output[$index] = [$astral_object[0], $datetime[0], $decimal_number[0]];
        }       
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
     * Constructs the Apogee collection.
     *
     * @return void
     */
    protected function buildObject(): void
    {
        $this->object = new Apogees(new FromArray($this->output));
    }

    /**
     * Gets the builded SynodicRhythm collection.
     *
     * @return Apogees
     */
    public function getResult(): Apogees
    {
        if (!$this->completed) $this->query();
        return $this->object;
    }
}