<?php
namespace MarcoConsiglio\Ephemeris;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Command\Param;
use AdamBrett\ShellWrapper\Runners\Exec;
use AdamBrett\ShellWrapper\Runners\DryRunner;
use AdamBrett\ShellWrapper\Runners\FakeRunner;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use MarcoConsiglio\Ephemeris\Exceptions\SwissEphemerisError;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Templates\Moon\SynodicRhythmTemplate;

class LaravelSwissEphemeris
{
    /**
     * The shell used to query the Swiss Ephemeris.
     *
     * @var \AdamBrett\ShellWrapper\Runners\Exec
     */
    protected Exec|DryRunner|FakeRunner $shell;

    /**
     * The reference to the Swiss Ephemeris executable.
     *
     * @var \AdamBrett\ShellWrapper\Command
     */
    protected Command $command;

    /**
     * The name of the Swiss Ephemeris executable.
     */
    const SWISS_EPHEMERIS_EXECUTABLE = "swetest";

    /**
     * The resource folder where are placed Swiss Ephemeris resources.
     */
    const SWISS_EPHEMERIS_PATH = "swiss_ephemeris";

    /**
     * The latitude coordinate used to query the Swiss Ephemeris.
     *
     * @var float
     */
    protected float $latitude;

    /**
     * The longitude coordinate used to query the Swiss Ephemeris.
     *
     * @var float
     */
    protected float $longitude;

    /**
     * The timezone used to calculate the local time for The time zone used to convert local time to universal time, 
     * to obtain a precise moment in which to consult the Swiss Ephemeris.
     *
     * @var string
     */
    protected string $timezone;

    /**
     * The altitude above sea level in meters of the observation point for which the ephemeris is queried.
     *
     * @var float
     */
    protected float $altitude;

    /**
     * Construct di ephemeris query based on a location and timezone.
     *
     * @param string $latitude in decimal format.
     * @param string $longitude in decimal format.
     * @param string $timezone like "Europe/London"
     * @param float $altitude in meters.
     * @param Exec|DryRunner|FakeRunner|null $shell The shell wrapper used to execute the command. 
     * Use this only for testing purposes, not in production environment.
     * @param ?Command $command The command to execute. 
     * Use this only for testing purposes, not in production environment.
     */
    public function __construct(
        float $latitude, 
        float $longitude, 
        string $timezone, 
        float $altitude = 0.0, 
        Exec|DryRunner|FakeRunner|null $shell = null, 
        ?Command $command = null
    ) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->timezone = $timezone; 
        $this->altitude = $altitude;
        $this->shell = $shell ?? new Exec();
        $this->command = $command ?? new Command(
            resource_path('swiss_ephemeris') . DIRECTORY_SEPARATOR . self::SWISS_EPHEMERIS_EXECUTABLE
        );
    }

    /**
     * Get the Moon synodic rhythm starting from $start_date up until a specified number 
     * of $days. Each step is long $step_size minutes.
     *
     * @param \Carbon\CarbonInterface $start_date The starting date of the response.
     * @param integer $days The number of days included in the response.
     * @param integer $step_size Duration in minutes of each step of the response.
     * @return SynodicRhythm
     * @throws SwissEphemerisError in case the swetest executable returns errors in its own output.
     */
    public function getMoonSynodicRhythm(CarbonInterface $start_date, int $days = 30, int $step_size = 60)
    {
        $query = new SynodicRhythmTemplate($start_date, $days, $step_size, $this->shell, $this->command);
        return $query->getResult();
        // // $this->setDebugHeader(false);
        // foreach ($this->prepareFlagsForMoonSynodicRhythm($start_date, $days, $step_size) as $flag) {
        //     $this->command->addFlag($flag);
        // }
        // // We don't want the header while parsing the response.
        // $this->command->addArgument($this->noHeaderPlease());

        // // Run the command.
        // $this->shell->run($this->command);
        // $output = $this->shell->getOutput();

        // // Check for errors within the output.
        // $this->checkErrors($output);

        // // Parse the output.
        // foreach ($output as $index => $row) {
        //     $datetime = '';
        //     $decimal_number = 0.0;
        //     preg_match(RegExPattern::UniversalAndTerrestrialDateTime->value, $row, $datetime);
        //     preg_match(RegExPattern::RelativeDecimalNumber->value, $row, $decimal_number);
        //     $output[$index] = [$datetime[0], $decimal_number[0]];
        // }

        // // Add labels to parsed values so the builder accesses the correct value.
        // $output = $this->reMapColumns($output, [
        //     0 => "timestamp",
        //     1 => "angular_distance"
        // ]);

        // // Build the rhythm.
        // return new MoonSynodicRhythm(new FromArray($output)->fetchCollection());
    }

    // /**
    //  * Prepare the flags used to request the synodic rhythm of the moon.
    //  *
    //  * @param CarbonInterface $start_date
    //  * @param integer $days
    //  * @param integer $step_size
    //  * @return array{SwissEphemerisFlag}
    //  */
    // protected function prepareFlagsForMoonSynodicRhythm(
    //     CarbonInterface $start_date, 
    //     int $days = 30, 
    //     int $step_size = 60
    // ): array
    // {
    //     $start_date = new SwissEphemerisDateTime($start_date);
    //     $steps = $days * 24;
    //     // Warning! Changing the response format will cause errors in getMoonSynodicRhythm() method.
    //     $response_format = OutputFormat::GregorianDateFormat->value.OutputFormat::LongitudeDecimal->value;
    //     return [
    //         new SwissEphemerisFlag(CommandFlag::ObjectSelection->value, SinglePlanet::Moon->value),
    //         new SwissEphemerisFlag(CommandFlag::DifferentialObjectSelection->value, SinglePlanet::Sun->value),
    //         new SwissEphemerisFlag(CommandFlag::BeginDate->value, $start_date->toGregorianDate()),
    //         new SwissEphemerisFlag(CommandFlag::InputTerrestrialTime->value, $start_date->toTimeString()),
    //         new SwissEphemerisFlag(CommandFlag::StepsNumber->value, $steps),
    //         new SwissEphemerisFlag(CommandFlag::TimeSteps->value, $step_size.TimeSteps::MinuteSteps->value),
    //         new SwissEphemerisFlag(CommandFlag::ResponseFormat->value, $response_format)
    //     ];
    // }

    // /**
    //  * Change columns in a readable format
    //  *
    //  * @param array<string> $output
    //  * @param array<int,string> $columns Columns with their based zero position as key and their name as value.
    //  * @return array
    //  */
    // protected function reMapColumns(array $output, array $columns)
    // {
    //     return collect($output)->map(function ($record) use ($columns) {
    //         foreach ($columns as $column_position => $column_name) {
    //             $transformed_record[$column_name] = $record[$column_position];
    //         }
    //         return $transformed_record;
    //     })->all();
    // }

    // /**
    //  * Prepare the argument to remove the header of the response.
    //  *
    //  * @return SwissEphemerisArgument
    //  */
    // protected function noHeaderPlease(): SwissEphemerisArgument
    // {
    //     return new SwissEphemerisArgument(CommandFlag::NoHeader->value);
    // }

    // /**
    //  * Search for errors in the swetest executable output.
    //  *
    //  * @param array $output
    //  * @return void
    //  * @throws SwissEphemerisError if at least one error found.
    //  */
    // protected function checkErrors(array &$output)
    // {
    //     $error_match = '';
    //     $errors_list = [];
    //     foreach ($output as $row) {
    //         if (preg_match(RegExPattern::SwetestError->value, $output[0], $error_match) == 1) {
    //             array_push($errors_list, $error_match[1]);
    //         }
    //     }
    //     if (!empty($errors_list)) {
    //         throw new SwissEphemerisError($errors_list);
    //     }
    // }
}