<?php
namespace MarcoConsiglio\Ephemeris\Templates\Moon;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Runners\DryRunner;
use AdamBrett\ShellWrapper\Runners\Exec;
use AdamBrett\ShellWrapper\Runners\FakeRunner;
use Carbon\CarbonInterface;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisArgument;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisFlag;
use MarcoConsiglio\Ephemeris\Enums\CommandFlag;
use MarcoConsiglio\Ephemeris\Enums\OutputFormat;
use MarcoConsiglio\Ephemeris\Enums\RegExPattern;
use MarcoConsiglio\Ephemeris\Enums\SinglePlanet;
use MarcoConsiglio\Ephemeris\Enums\TimeSteps;
use MarcoConsiglio\Ephemeris\LaravelSwissEphemeris;
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
     * The query start date.
     *
     * @var CarbonInterface
     */
    protected CarbonInterface $start_date;

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
        $start_date = new SwissEphemerisDateTime($this->start_date);
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
        foreach ($this->output as $index => $row) {
            $datetime = '';
            $decimal_number = 0.0;
            preg_match(RegExPattern::UniversalAndTerrestrialDateTime->value, $row, $datetime);
            preg_match(RegExPattern::RelativeDecimalNumber->value, $row, $decimal_number);
            $this->output[$index] = [$datetime[0], $decimal_number[0]];
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
     * Constructs the SynodicRhythm collection.
     *
     * @return void
     */
    protected function buildObject(): void
    {
        $this->object = new SynodicRhythm(new FromArray($this->output));           
    }

    /**
     * Gets the builded SynodicRhythm collection.
     *
     * @return SynodicRhythm
     */
    public function getResult(): SynodicRhythm
    {
        if (!$this->completed) $this->query();
        return $this->object;
    }
}