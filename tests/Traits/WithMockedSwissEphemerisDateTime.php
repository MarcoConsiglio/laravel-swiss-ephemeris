<?php
namespace MarcoConsiglio\Ephemeris\Tests\Traits;

use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;

trait WithMockedSwissEphemerisDateTime
{

    /**
     * Creates a mocked SwissEphemerisDateTime.
     *
     * @param integer $year
     * @param integer $month
     * @param integer $day
     * @param integer $hour
     * @param integer $minute
     * @param integer $second
     * @param ?string|null $tz
     * @return SwissEphemerisDateTime
     */
    protected function getMockedSwissEphemerisDateTime(
        int $year = 0, 
        int $month = 1, 
        int $day = 1, 
        int $hour = 0, 
        int $minute = 0, 
        int $second = 0, 
        ?string $tz = null): SwissEphemerisDateTime
    {
        $date = SwissEphemerisDateTime::create($year, $month, $day, $hour, $minute, $second, $tz);
        SwissEphemerisDateTime::setTestNow($date);
        return $date;
    }
}
