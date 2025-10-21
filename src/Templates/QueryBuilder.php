<?php
namespace MarcoConsiglio\Ephemeris\Templates;

use AdamBrett\ShellWrapper\Runners\Exec;
use AdamBrett\ShellWrapper\Runners\DryRunner;
use AdamBrett\ShellWrapper\Runners\FakeRunner;
use AdamBrett\ShellWrapper\Command;
use MarcoConsiglio\Ephemeris\Enums\RegExPattern;
use MarcoConsiglio\Ephemeris\Exceptions\SwissEphemerisError;

abstract class QueryBuilder
{
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

    abstract protected function prepareArguments(): void;
    
    abstract protected function prepareFlags(): void;

    protected function setHeader(): void {}

    protected function debug(): void {}

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

    abstract protected function parseOutput(): void;

    abstract protected function remapColumns(): void;

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
}