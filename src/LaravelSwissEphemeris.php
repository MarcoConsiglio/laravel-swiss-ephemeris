<?php
namespace MarcoConsiglio\Ephemeris;
use App\SwissEphemeris\Repository\SwissEphemerisRepository;
use App\SwissEphemeris\SwissEphemeris;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\SynodicRhythm\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;

class LaravelSwissEphemeris extends SwissEphemeris
{
    /**
     * The header of the Swiss Ephemeris response.
     *
     * @var array
     */
    protected array $header;

    /**
     * Construct di ephemeris based on a location and timezone.
     *
     * @param string $latitute in decimal format.
     * @param string $longitude in decimal format.
     * @param string $timezone
     * @param float $altitude in meters.
     */
    public function __construct(float $latitute, float $longitude, string $timezone, float $altitude = 0.0)
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
        $this->setDebugHeader(false);
        $this->query($parameters = [
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
            "f" => "Tl"
        ]);
        $this->execute();
        /** @var array */
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

    protected function getHeader(CarbonInterface $date)
    {
        $this->setDebugHeader(true);
        $output = $this->query([
            "b" => $date->toGregorianDate(),
            "ut" => $date->toTimeString(),
            "f" => "",
            "p" => ""
        ])->execute()->getOutput();
        return $output;
    }

    /**
     * Filter unwanted rows.
     *
     * @param array|\Illuminate\Support\Collection $output
     * @param int $steps
     * @return array|\Illuminate\Support\Collection
     */
    protected function filterUnwantedRows(array|Collection $output, int $steps): array|Collection 
    {
        if (is_array($output)) {
            return array_filter($output, function ($key) use ($steps) {
                return $key < $steps;
            }, ARRAY_FILTER_USE_KEY);
        }
        if ($output instanceof Collection) {
           return $output->take($steps);
        }
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