<?php
namespace MarcoConsiglio\Ephemeris\Templates\Moon;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Runners\DryRunner;
use AdamBrett\ShellWrapper\Runners\Exec;
use AdamBrett\ShellWrapper\Runners\FakeRunner;
use Carbon\CarbonInterface;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisArgument as Argument;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisFlag as Flag;
use MarcoConsiglio\Ephemeris\Enums\CommandFlag;
use MarcoConsiglio\Ephemeris\Enums\OutputFormat;
use MarcoConsiglio\Ephemeris\Enums\RegExPattern;
use MarcoConsiglio\Ephemeris\Enums\SinglePlanet;
use MarcoConsiglio\Ephemeris\Enums\TimeSteps;
use MarcoConsiglio\Ephemeris\LaravelSwissEphemeris;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Apogees\FromRecords;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Apogees;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Templates\QueryBuilder;

class ApogeeTemplate extends QueryBuilder
{
    /**
     * The query start date.
     *
     * @var CarbonInterface
     */
    protected CarbonInterface $start_date;

    /**
     * How many days of ephemeris to request.
     *
     * @var integer
     */
    protected int $days;

    /**
     * How much time elapses between each step of the 
     * ephemeris expressed in minutes.
     *
     * @var integer
     */
    protected int $step_size;

    /**
     * The column names to be given to the columns of 
     * the ephemeris answer.
     *
     * @var array
     */
    protected array $columns = [
        0 => "object",
        1 => "timestamp",
        2 => "longitude"
    ];

    /**
     * The object that will be built with the requested 
     * ephemeris.
     *
     * @var Apogees
     */
    protected Apogees $object;

    /**
     * Construct the template in order to produce
     * a MoonAnomalisticRhythm
     *
     * @param CarbonInterface $start_date
     * @param integer $days
     * @param integer $step_size
     * @param Exec|DryRunner|FakeRunner|null|null $shell
     * @param Command|null $command
     */
    public function __construct(
        CarbonInterface $start_date,
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

    protected function prepareArguments(): void
    {

    }

    protected function prepareFlags(): void
    {
        if (! $this->start_date instanceof SwissEphemerisDateTime) {
            $start_date = new SwissEphemerisDateTime($this->start_date);
        } else $start_date = $this->start_date;
        $steps = $this->days * 24; // This is a problem when setting step_size different than 60 minutes.
        $this->command->addFlag(new Flag(CommandFlag::BeginDate->value, $start_date->toGregorianDate()));
        $this->command->addFlag(new Flag(CommandFlag::StepsNumber->value, $steps));
        $this->command->addFlag(new Flag(CommandFlag::TimeSteps->value, $this->step_size.TimeSteps::MinuteSteps->value));
        $this->command->addFlag(new Flag(CommandFlag::InputTerrestrialTime->value, $start_date->toTimeString()));
        $this->command->addFlag(new Flag(CommandFlag::ObjectSelection->value, SinglePlanet::Moon->value.SinglePlanet::InterpolatedLunarApogee->value));
        // Warning! Changing the object format will cause errors in getMoonAnomalisticRhythm() method.
        $object_format = OutputFormat::PlanetName->value.OutputFormat::GregorianDateTimeFormat->value.OutputFormat::LongitudeDecimal->value;
        $this->command->addFlag(new Flag(CommandFlag::ResponseFormat->value, $object_format));
    }

    protected function setHeader(): void
    {
        // No header.
        $this->command->addArgument(new Argument(CommandFlag::NoHeader->value));
    }

    protected function parseOutput(): void
    {
        foreach ($this->output as $index => $row) {
            $object = '';
            $datetime = '';
            $decimal_number = 0.0;
            $columns_name_regex = RegExPattern::getObjectNamesRegex(RegExPattern::Moon."|".RegExPattern::InterpolatedApogee);
            preg_match($columns_name_regex, $row, $object);
            preg_match(RegExPattern::UniversalAndTerrestrialDateTime->value, $row, $datetime);
            preg_match(RegExPattern::RelativeDecimalNumber->value, $row, $decimal_number);
            $this->output[$index] = [$object[0], $datetime[0], $decimal_number[0]];
        }       
    }

    protected function remapColumns(): void
    {
        $this->remapColumnsBy($this->columns);
    }

    protected function buildObject(): void
    {
        $this->object = new Apogees(new FromRecords($this->output)->fetchCollection());
    }

    public function getResult(): ?Apogees
    {
        if (!$this->completed) $this->query();
        return $this->object;
    }
}