<?php
namespace MarcoConsiglio\Ephemeris;
use App\SwissEphemeris\Repository\SwissEphemerisRepository;
use App\SwissEphemeris\SwissEphemeris;
use App\SwissEphemeris\SwissEphemerisException;
use Carbon\Carbon;
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
     * Encode the result in a php array, without "name" key as the parent class
     * would do.
     * @param $output
     * @return array|null
     */
    public function encodePhpArray($output): ?array
    {
        $php_array = array();
        $i = 0;
        if (is_array($output)) {

            foreach ($output as $value) {

                $php_array[$i] = $this->splitOutput($value);
                $i++;
            }
        }

        return $php_array;
    }

    /**
     * Get the moon synodic rhythm starting from $start_date and $start time
     * up until a specified number of $days. The steps are 24 per $day, one per hour.
     *
     * @param string $start_date
     * @param string $start_time
     * @param integer $days
     * @return \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm
     */
    public function getMoonSynodicRhythm(string $start_date, int $days = 30, string $start_time = "00:00:00")
    {
        $steps = $days * 24;
        $this->query([
            // Moon
            "p" => "1",
            // Sun
            "d" => "0",
            // Starting from
            "b" => $start_date,
            "ut" => $start_time,
            // No. steps
            "n" => $steps,
            // Each step during 1 hour
            "s" => 60 . "m",
            "f" => "TPl",
            "head"
        ]);
        $this->execute();
        if ($this->getStatus() != 0) {
            throw new SwissEphemerisException($this->getName());
        }
        /**
         * @var array
         */
        $output = $this->getOutput();
        $output = $this->filterUnwantedRows($output, $steps);
        $output = $this->reMapColumns($output, [
            0 => "timestamp",
            1 => null,
            2 => "angular_distance"
        ]);      

        return new SynodicRhythm($output);
        
        // Elaborate data.
        // $result->transform(function ($item, $key) {
        //     $item["timestamp"] = Carbon::createFromFormat("d.m.Y H:m:i", trim(str_replace("UT", "", $item["timestamp"])));
        //     $item["angular_distance"] = Angle::createFromDecimal((float) trim($item["angular_distance"]));
        //     /**
        //      * @var \MarcoConsiglio\Trigonometry\Angle
        //      */
        //     $alfa = $item["angular_distance"];
        //     $item["percentage"] = round($alfa->toDecimal() / 180, 2, PHP_ROUND_HALF_DOWN);
        //     return $item;
        // });

        // return $result;
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