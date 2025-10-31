<?php
namespace MarcoConsiglio\Ephemeris\Templates\Moon;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Runners\DryRunner;
use AdamBrett\ShellWrapper\Runners\Exec;
use AdamBrett\ShellWrapper\Runners\FakeRunner;
use MarcoConsiglio\Ephemeris\LaravelSwissEphemeris;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Templates\QueryTemplate;

/**
 * The template for an ephemeris query to obtain 
 * the Moon anomalistic rhythm.
 * 
 * 
 */
abstract class AnomalisticTemplate extends QueryTemplate
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
     * Remap the output in an associative array,
     * with the columns name as the key.
     *
     * @return void
     */
    protected function remapColumns(): void
    {
        $this->remapColumnsBy($this->columns);
    }
}