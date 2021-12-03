<?php
namespace MarcoConsiglio\Ephemeris;
use App\SwissEphemeris\Repository\SwissEphemerisRepository;

class LaravelSwissEphemeris extends SwissEphemerisRepository
{
    /**
     * Construct di ephemeris based on a location and timezone.
     *
     * @param string $latitute
     * @param string $longitude
     * @param string $timezone
     */
    public function __construct(string $latitute, string $longitude, string $timezone)
    {
        $this->setLatitude($latitute);
        $this->setLongitude($longitude);
        $this->setTimezone($timezone);  
    }

    /**
     * Get the moon synodic rhythm starting from $start_date and $start time
     * up until a specified number of $days. The steps are 24 per $day.
     *
     * @param string $start_date
     * @param string $start_time
     * @param integer $days
     */
    public function getMoonSynodicRhythm(string $start_date, string $start_time = "00:00:00", int $days = 30)
    {
        return $this->query([
            // Moon
            "p" => "1",
            // Sun
            "d" => "0",
            // Starting from
            "b" => $start_date,
            "ut" => $start_time,
            // No. steps, each step during 1 hour
            "s" => $days * 24 * 60 . "m"
        ])->execute()->getOutput();
    }
}