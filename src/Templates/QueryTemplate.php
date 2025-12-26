<?php
namespace MarcoConsiglio\Ephemeris\Templates;

use RoundingMode;
use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Runners\DryRunner;
use AdamBrett\ShellWrapper\Runners\Exec;
use AdamBrett\ShellWrapper\Runners\FakeRunner;
use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisArgument;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisFlag;
use MarcoConsiglio\Ephemeris\Enums\CommandFlag;
use MarcoConsiglio\Ephemeris\Enums\RegExPattern;
use MarcoConsiglio\Ephemeris\Enums\TimeSteps;
use MarcoConsiglio\Ephemeris\Exceptions\SwissEphemerisError;
use MarcoConsiglio\Ephemeris\LaravelSwissEphemeris;
use MarcoConsiglio\Ephemeris\Observer\Geocentric;
use MarcoConsiglio\Ephemeris\Observer\PointOfView;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;

/**
 * The template for an ephemeris query.
 */
abstract class QueryTemplate
{
    /**
     * The number of hours in a day.
     */
    protected const HOURS_IN_A_DAY = 24;

    /**
     * The number of minutes in a hour.
     */
    protected const MINUTES_IN_A_HOUR = 60;

    /**
     * The query start date.
     *
     * @var SwissEphemerisDateTime
     */
    protected SwissEphemerisDateTime $start_date;

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
     * The topocentric locale.
     *
     * @var PointOfView|null
     */
    protected PointOfView|null $pov;

    /** 
     * @var Exec|DryRunner|FakeRunner|null $shell The shell wrapper used to execute the command. 
     * Use this only for testing purposes, not in production environment.
     */
    protected Exec|DryRunner|FakeRunner|null $shell = null;

    /**
     * The command to be executed.
     *
     * @var ?Command
     */
    protected ?Command $command = null;

    /**
     * The return value from the command.
     *
     * @var integer
     */
    public protected(set) int $return_value;

    /**
     * The output from the swetest executable.
     *
     * @var array|Collection
     */
    protected array|Collection $output;

    /**
     * Indicates whether the template is completed or not.
     *
     * @var boolean
     */
    protected bool $completed = false;

    /**
     * The warnings list found in the output.
     * 
     * @var string[]
     */
    public protected(set) array $warnings;

    /**
     * The notices list found in the output.
     * 
     * @var string[]
     */
    public protected(set) array $notices;

    /**
     * Construct the template in order to produce
     * a MoonSynodicRhythm object.
     *
     * @param SwissEphemerisDateTime $start_date
     * @param integer $days The length of the requested ephemeris interval.
     * @param integer $step_size The sampling rate of the ephemeris expressed 
     * in minutes per each step of the ephemeris response.
     * @param PointOfView|null $pov The point of View
     * @param Exec|DryRunner|FakeRunner|null $shell The shell used to call the "swetest" executable.
     * Do not use this parameter unless for testing purposes.
     * @param Command|null $command The command to be executed.
     * This parameter is useless and it will be deprecated.
     */
    public function __construct(
        SwissEphemerisDateTime          $start_date, 
        int                             $days = 30, 
        int                             $step_size = 60,
        PointOfView|null                $pov = null,
        Exec|DryRunner|FakeRunner|null  $shell = null, 
        Command|null                    $command = null
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
        $this->pov = $pov ?? new Geocentric; 
    }

    /**
     * The template of a query to the Swiss Ephemeris executable.
     *
     * @return void
     */
    final protected function query(): void
    {
        $this->buildCommand();
        $this->runCommand();
        $this->checkErrors();
        $this->checkWarnings();
        $this->checkNotices();
        $this->removeEmptyLines();
        $this->formatHook();
        $this->parseOutput();
        $this->remapColumns();
        $this->buildObject();
        $this->completed = true;
    }

    /**
     * Set arguments for the swetest executable.
     *
     * @return void
     */
    abstract protected function setArguments(): void;
    
    /**
     * Set flags for the swetest executable.
     *
     * @return void
     */
    abstract protected function setFlags(): void;

    /**
     * Set whether or not the header appears in the 
     * ephemeris response. It defaults to no header.
     *
     * @return void
     */
    protected function setHeader(): void
    {
        // No header.
        $this->command->addArgument(new SwissEphemerisArgument(CommandFlag::NoHeader->value));
    }

    /**
     * It formats the output before parsing it, if necessary.
     *
     * @return void
     */
    abstract protected function formatHook(): void;

    /**
     * It sets whether to include debug information in the response.
     *
     * @return void
     * @codeCoverageIgnore
     */
    protected function debug(): void {}

    /**
     * Construct the swetest command with the correct inputs.
     *
     * @return void
     */
    final protected function buildCommand(): void
    {
        $this->setArguments();
        $this->setCommonFlags();
        $this->setFlags();
        $this->setHeader();
    }

    /**
     * It runs the swetest executable.
     *
     * @return void
     * @codeCoverageIgnore
     */
    protected function runCommand(): void 
    {
        if ($this->shell instanceof Exec) {
            $this->shell->run($this->command);
            $this->return_value = $this->shell->getReturnValue();
            $this->output = collect($this->shell->getOutput());
        } 

        // Used for testing purposes.
        if ($this->shell instanceof FakeRunner) {
            $fake_output = $this->shell->getStandardOut();
            $this->output = collect(explode(PHP_EOL, (string) $fake_output));
        }
    }

    /**
     * Search for errors in the swetest executable output.
     *
     * @param array $output
     * @return void
     * @throws SwissEphemerisError if at least one error have been found.
     */
    protected function checkErrors(): void 
    {
        $errors_list = [];
        $this->output->each(function($row) use(&$errors_list): void {
            if (preg_match(
                    RegExPattern::SwetestError->value, 
                    $row, 
                    $error_match)) 
            {
                $errors_list[] = $error_match[1];
            } 
        });
        if (!empty($errors_list)) throw new SwissEphemerisError($errors_list);
    }

    /**
     * Search for warnings in the swetest executable output.
     *
     * @return void
     */
    protected function checkWarnings(): void
    {
        $warning_list = [];
        $this->output->reject(function($row) use(&$warning_list) {
            if (preg_match(
                RegExPattern::SwetestWarning->value, 
                $row, $warning_match)) 
            {
                $warning_list[] = $warning_match[1];
                return true;
            } else return false;
        });
        $this->warnings = $warning_list;
    }

    /**
     * Search for notices in the swetest executable output.
     *
     * @return void
     */
    protected function checkNotices(): void
    {
        $notices_list = [];
        $this->output = $this->output->reject(function($row) use(&$notices_list) {
            if (preg_match(
                RegExPattern::SwetestUsing->value, 
                $row, 
                $notice_match)) 
            {
                $notices_list[] = $notice_match[0];
                return true;
            } else return false;
        });
        $this->notices = $notices_list;
    }

    /**
     * Remove empty line in the swetest executable output.
     *
     * @return void
     */
    protected function removeEmptyLines()
    {
        $this->output = $this->output->reject(fn($row) => preg_match(
                RegExPattern::EmptyLine->value, 
            (string) $row, $empty_line_match
        ));
    }

    /**
     * Remap the output in an associative array,
     * with the columns name as the key.
     *
     * @return void
     */
    abstract protected function remapColumns(): void;

    /**
     * Construct the correct object with a builder.
     *
     * @return void
     */
    abstract protected function buildObject(): void;

    /**
     * Return the builded object.
     *
     * @return mixed
     */
    public function getResult()
    {
        if (!$this->completed) $this->query();
        return $this->fetchObject();
    }

    /**
     * Remap columns to have names speci
     *
     * @param array $columns
     * @return void
     */
    protected function remapColumnsBy(array $columns)
    {
        $this->output->transform(function ($record) use ($columns) {
            foreach ($columns as $column_position => $column_name) {
                $transformed_record[$column_name] = $record[$column_position];
            }
            return $transformed_record;
        });        
    }

    /**
     * Calculate the steps of the ephemeris request.
     *
     * @return integer
     */
    protected function getStepsNumber(): int
    {
        return round(
            ($this->days * self::HOURS_IN_A_DAY * self::MINUTES_IN_A_HOUR) / $this->step_size,
            0, 
            RoundingMode::HalfTowardsZero
        );
    }

    /**
     * Remove the line number $index.
     *
     * @param integer $index Zero-based line number.
     * @return void
     * @codeCoverageIgnore
     */
    protected function removeLine(int $index): void
    {
        unset($this->output[$index]);
    }

    /**
     * Return the builded object.
     *
     * @return mixed
     */
    abstract protected function fetchObject();

    /**
     * Parse the response.
     *
     * @return void
     */
    protected function parseOutput(): void
    {
        $this->output->transform($this->parse(...));
    }

    /**
     * Parse a line of the raw ephemeris output.
     * 
     * @return array|null
     */
    abstract protected function parse(string $text): array|null;

    /**
     * Return the columns names used by the concrete template.
     */
    abstract static public function getColumns(): array;

    /**
     * It sets the common flags for every template
     * that query the swiss ephemeris executable.
     */
    protected function setCommonFlags(): void
    {
        $this->command->addFlag(new SwissEphemerisFlag(CommandFlag::BeginDate->value, $this->start_date->toGregorianDate()));
        $this->command->addFlag(new SwissEphemerisFlag(CommandFlag::InputTerrestrialTime->value, $this->start_date->toTimeString()));
        $this->command->addFlag(new SwissEphemerisFlag(CommandFlag::StepsNumber->value, $this->getStepsNumber()));
        $this->command->addFlag(new SwissEphemerisFlag(CommandFlag::TimeSteps->value, $this->step_size.TimeSteps::MinuteSteps->value));
    }

}