<?php
namespace MarcoConsiglio\Ephemeris;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Command\Param;
use AdamBrett\ShellWrapper\Runners\DryRunner;
use AdamBrett\ShellWrapper\Runners\Exec;
use AdamBrett\ShellWrapper\Runners\FakeRunner;
use Carbon\CarbonInterface;
use MarcoConsiglio\Ephemeris\Exceptions\SwissEphemerisError;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\FromCollections;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\AnomalisticRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\DraconicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Templates\Moon\ApogeeTemplate;
use MarcoConsiglio\Ephemeris\Templates\Moon\DraconicTemplate;
use MarcoConsiglio\Ephemeris\Templates\Moon\PerigeeTemplate;
use MarcoConsiglio\Ephemeris\Templates\Moon\SynodicRhythmTemplate;

/**
 * The main endpoint to obtain Swiss Ephemeris data.
 */
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
     * Latitude, longitude and altitude of a topocentric point of view.
     */
    public TopocentricLocale|null $locale;

    /**
     * The timezone used to calculate the local time for the time zone choose.
     *
     * @var string
     */
    protected string|null $timezone;

    /**
     * Construct the ephemeris.
     *
     * @param TopocentricLocale|null $locale The topocentric point of view.
     * @param float $altitude in meters.
     * @param Exec|DryRunner|FakeRunner|null $shell The shell wrapper used to execute the command. 
     * Use this only for testing purposes, not in production environment.
     * @param ?Command $command The command to execute. 
     * Use this only for testing purposes, not in production environment.
     */
    public function __construct(
        TopocentricLocale|null          $locale, 
        string|null                     $timezone = null, 
        Exec|DryRunner|FakeRunner|null  $shell = null, 
        ?Command                        $command = null
    ) {
        $this->locale = $locale;
        $this->timezone = $timezone; 
        $this->shell = $shell ?? new Exec();
        $this->command = $command ?? new Command(
            resource_path('swiss_ephemeris') . DIRECTORY_SEPARATOR . self::SWISS_EPHEMERIS_EXECUTABLE
        );
    }

    /**
     * Returns the Moon synodic rhythm starting from $start_date up until a specified number 
     * of $days. Each step is long $step_size minutes.
     *
     * @param CarbonInterface $start_date The starting date of the response.
     * @param integer $days The number of days included in the response.
     * @param integer $step_size Duration in minutes of each step of the response.
     * @return SynodicRhythm
     * @throws SwissEphemerisError in case the swetest executable returns errors in its own output.
     */
    public function getMoonSynodicRhythm(
        CarbonInterface $start_date, 
        int $days = 30, 
        int $step_size = 60): SynodicRhythm
    {
        $start_date = $this->normalizeDatetime($start_date);
        $query = new SynodicRhythmTemplate($start_date, $days, $step_size, $this->locale, $this->shell, $this->command);
        return $query->getResult();
    }

    /**
     * Returns the Moon anomalistic rhythm starting from $start_date up until a specified number
     * of $days. Each step is long $step_size minutes.
     *
     * @param CarbonInterface $start_date The starting date of the response.
     * @param integer $days The number of days included in the response.
     * @param integer $step_size Duration in minutes of each step of the response.
     * @return AnomalisticRhythm
     * @throws SwissEphemerisError in case the swetest executable returns errors in its own output.
     */
    public function getMoonAnomalisticRhythm(
        CarbonInterface $start_date,
        $days = 30,
        $step_size = 60
    ): AnomalisticRhythm 
    {
        $start_date = $this->normalizeDatetime($start_date);
        $apogees_query = new ApogeeTemplate($start_date, $days, $step_size, null, $this->shell, $this->command);
        $perigees_query = new PerigeeTemplate($start_date, $days, $step_size, null, $this->shell, $this->command);
        $apogees = $apogees_query->getResult();
        $perigees = $perigees_query->getResult();
        return new AnomalisticRhythm(new FromCollections($apogees, $perigees));
    }

    /**
     * Returns the Moon draconic rhythm starting from $start_date up until a specified number
     * of $days. Each step is long $step_size minutes.
     *
     * @param CarbonInterface $start_date The starting date of the response.
     * @param integer $days The number of days included in the response.
     * @param integer $step_size Duration in minutes of each step of the response.
     * @return DraconicRhythm
     * @throws SwissEphemerisError in case the swetest executable returns errors in its own output.
     */
    public function getMoonDraconicRhythm(
        CarbonInterface $start_date,
        $days = 30,
        $step_size = 60
    ): DraconicRhythm
    {
        $start_date = $this->normalizeDatetime($start_date);
        $query = new DraconicTemplate($start_date, $days, $step_size, null, $this->shell, $this->command);
        $draconic_rhythm = $query->getResult();
        return $draconic_rhythm;
    }

    /**
     * Transform a Carbon instance into a
     * SwissEphemerisDateTime instance.
     *
     * @param CarbonInterface $datetime
     * @return SwissEphemerisDateTime
     * @codeCoverageIgnore
     */
    protected function transformDatetime(CarbonInterface $datetime): SwissEphemerisDateTime
    {
        return SwissEphemerisDateTime::createFromCarbon($datetime);
    }

    /**
     * Normalize the $datetime to a
     * SwissEphemerisDateTime instance.
     *
     * @param CarbonInterface $datetime
     * @return SwissEphemerisDateTime
     */
    protected function normalizeDatetime(CarbonInterface $datetime): SwissEphemerisDateTime
    {
        if (! $datetime instanceof SwissEphemerisDateTime) 
            return $this->transformDatetime($datetime); // @codeCoverageIgnore
        else return $datetime;
    }
}