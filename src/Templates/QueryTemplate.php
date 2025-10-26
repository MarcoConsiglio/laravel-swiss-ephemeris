<?php
namespace MarcoConsiglio\Ephemeris\Templates;

use RoundingMode;
use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Runners\DryRunner;
use AdamBrett\ShellWrapper\Runners\Exec;
use AdamBrett\ShellWrapper\Runners\FakeRunner;
use MarcoConsiglio\Ephemeris\Enums\RegExPattern;
use MarcoConsiglio\Ephemeris\Exceptions\SwissEphemerisError;

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
     * @var Exec|DryRunner|FakeRunner|null $shell The shell wrapper used to execute the command. 
     * Use this only for testing purposes, not in production environment.
     */
    protected Exec|DryRunner|FakeRunner|null $shell = null;

    /**
     * Undocumented variable
     *
     * @var ?Command $command The command to execute.
     */
    protected ?Command $command = null;

    /**
     * The output from the swetest executable.
     *
     * @var array
     */
    protected array $output;

    /**
     * Indicates whether the template is completed or not.
     *
     * @var boolean
     */
    protected bool $completed = false;

    final protected function query(): void
    {
        $this->buildCommand();
        $this->runCommand();
        $this->checkErrors();
        $this->parseOutput();
        $this->remapColumns();
        $this->buildObject();
        $this->completed = true;
    }

    /**
     * Prepares arguments for the swetest executable.
     *
     * @return void
     */
    abstract protected function prepareArguments(): void;
    
    /**
     * Prepares flags for the swetest executable.
     *
     * @return void
     */
    abstract protected function prepareFlags(): void;

    /**
     * Sets whether or not the header appears in the 
     * ephemeris response.
     *
     * @return void
     */
    abstract protected function setHeader(): void;

    /**
     * Sets whether to include debug information in the response.
     *
     * @return void
     * @codeCoverageIgnore
     */
    protected function debug(): void {}

    /**
     * Constructs the swetest command with the correct inputs.
     *
     * @return void
     */
    final protected function buildCommand(): void
    {
        $this->prepareArguments();
        $this->prepareFlags();
        $this->setHeader();
    }

    /**
     * Run the swetest executable.
     *
     * @return void
     */
    protected function runCommand(): void 
    {
        $this->shell->run($this->command);
        if ($this->shell instanceof Exec) $this->output = $this->shell->getOutput();
        // Used for testing purposes.
        if ($this->shell instanceof FakeRunner) {
            $fake_output = $this->shell->getStandardOut();
            $this->output = explode(PHP_EOL, $fake_output);
        }
    }

    /**
     * Search for errors in the swetest executable output.
     *
     * @param array $output
     * @return void
     * @throws SwissEphemerisError if at least one error found.
     */
    protected function checkErrors(): void 
    {
        $error_match = '';
        $errors_list = [];
        foreach ($this->output as $row) {
            if (preg_match(RegExPattern::SwetestError->value, $this->output[0], $error_match) == 1) {
                array_push($errors_list, $error_match[1]);
            }
        }
        if (!empty($errors_list)) {
            throw new SwissEphemerisError($errors_list);
        }
    }

    /**
     * Parse the response.
     *
     * @return void
     */
    abstract protected function parseOutput(): void;

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

    abstract public function getResult();

    protected function remapColumnsBy(array $columns)
    {
        $this->output = collect($this->output)->map(function ($record) use ($columns) {
            foreach ($columns as $column_position => $column_name) {
                $transformed_record[$column_name] = $record[$column_position];
            }
            return $transformed_record;
        })->all();        
    }

    /**
     * Calcs the steps of the ephemeris response.
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
}