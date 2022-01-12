<?php
namespace MarcoConsiglio\Ephemeris;
use App\SwissEphemeris\Repository\SwissEphemerisRepository;
use App\SwissEphemeris\SwissEphemeris;
use App\SwissEphemeris\SwissEphemerisException;
use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\SynodicRhythm\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;
use MarcoConsiglio\Trigonometry\Angle;

class LaravelSwissEphemeris extends SwissEphemeris
{
    /**
     * Construct di ephemeris based on a location and timezone.
     *
     * @param string $latitute
     * @param string $longitude
     * @param string $timezone
     */
    public function __construct(float $latitute, float $longitude, string $timezone)
    {
        parent::__construct();
        $this->setLatitude($latitute);
        $this->setLongitude($longitude);
        $this->setTimezone($timezone); 
        $this->setLibPhat(__DIR__."/../lib/");
    }

    /**
     * Get the Moon synodic rhythm starting from $start_date up until a specified number 
     * of $days. Each step is long $step_size minutes.
     *
     * @param \Carbon\Carbon $start_date
     * @param integer $days
     * @param integer $step_size The duration in minutes of each step in the ephemeris.
     * @return \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm
     */
    public function getMoonSynodicRhythm(Carbon $start_date, int $days = 30, int $step_size = 60)
    {
        $steps = $days * 24;
        $this->query([
            // Moon
            "p" => "1",
            // Sun
            "d" => "0",
            // Starting from
            "b" => $start_date->format("d.m.Y"),
            "ut" => $start_date->format("H:i:s"),
            // No. steps
            "n" => $steps,
            // Each step during 1 hour
            "s" => $step_size. "m",
            "f" => "Tl",
            "head"
        ]);
        $this->execute();
        /**
         * @var array
         */
        $output = $this->getOutput();
        $output = $this->filterUnwantedRows($output, $steps);
        $output = $this->reMapColumns($output, [
            0 => "timestamp",
            1 => "angular_distance"
        ]);      
        $builder = new FromArray($output);
        $builder->validateData();
        $builder->buildRecords();
        return new SynodicRhythm($builder->fetchCollection());
    }

    /**
     * Filter unwanted rows.
     *
     * @param array $output
     * @param int $steps
     * @return array
     */
    protected function filterUnwantedRows(array $output, int $steps): array 
    {
        return array_filter($output, function ($key) use ($steps) {
            return $key < $steps;
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Change columns in a readable format
     *
     * @param array $output
     * @param array $columns Columns with number as key and name as value.
     * @return array
     */
    protected function reMapColumns(array $output, array $columns)
    {
        return collect($output)->transform(function ($record) use ($columns) {
            foreach ($columns as $number => $column) {
                if ($column) {
                    $record[$column] = $record[$number];
                }
                unset($record[$number]);
            }
            return $record;
        })->all();
    }
}