<?php
namespace MarcoConsiglio\Ephemeris\Templates;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Runners\DryRunner;
use AdamBrett\ShellWrapper\Runners\Exec;
use AdamBrett\ShellWrapper\Runners\FakeRunner;
use Carbon\CarbonInterface;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisArgument;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisFlag;
use MarcoConsiglio\Ephemeris\Enums\CommandFlag;
use MarcoConsiglio\Ephemeris\Enums\OutputFormat;
use MarcoConsiglio\Ephemeris\Enums\SinglePlanet;
use MarcoConsiglio\Ephemeris\Enums\TimeSteps;
use MarcoConsiglio\Ephemeris\LaravelSwissEphemeris;
use MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythm;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Enums\RegExPattern;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonSynodicRhythm\FromArray;

class MoonSynodicRhythmTemplate extends QueryBuilder
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
        0 => "timestamp",
        1 => "angular_distance"
    ];

    /**
     * The object that will be built with the requested 
     * ephemeris.
     *
     * @var MoonSynodicRhythm
     */
    protected MoonSynodicRhythm $object;

    /**
     * Construct the template in order to produce
     * a MoonSynodicRhythm object.
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

    /**
     * Prepare the executable arguments.
     *
     * @return void
     */
    protected function prepareArguments(): void
    {

    }

    /**
     * Prepare the executable flags.
     *
     * @return void
     */
    protected function prepareFlags(): void
    {
        $start_date = new SwissEphemerisDateTime($this->start_date);
        $steps = $this->days * 24;
        // Warning! Changing the object format will cause errors in getMoonSynodicRhythm() method.
        $object_format = OutputFormat::GregorianDateFormat->value.OutputFormat::LongitudeDecimal->value;
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
     * Analyze the output of the ephemeris request.
     *
     * @return void
     */
    protected function parseOutput(): void
    {
        foreach ($this->output as $index => $row) {
            $datetime = '';
            $decimal_number = 0.0;
            preg_match(RegExPattern::UniversalAndTerrestrialDateTime->value, $row, $datetime);
            preg_match(RegExPattern::RelativeDecimalNumber->value, $row, $decimal_number);
            $this->output[$index] = [$datetime[0], $decimal_number[0]];
        }
    }

    /**
     * Remaps the ephemeris output columns.
     *
     * @return void
     */
    protected function remapColumns(): void
    {
        $columns = $this->columns;
        $this->output = collect($this->output)->map(function ($record) use ($columns) {
            foreach ($columns as $column_position => $column_name) {
                $transformed_record[$column_name] = $record[$column_position];
            }
            return $transformed_record;
        })->all();            
    }

    /**
     * Constructs the template result object.
     *
     * @return void
     */
    protected function buildObject(): void
    {
        $this->object = new MoonSynodicRhythm(new FromArray($this->output)->fetchCollection());           
    }

    /**
     * Gets the template result object.
     *
     * @return MoonSynodicRhythm
     */
    public function getResult(): MoonSynodicRhythm
    {
        if (!$this->completed) $this->query();
        return $this->object;
    }
}