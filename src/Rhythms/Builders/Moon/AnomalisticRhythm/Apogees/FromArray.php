<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Apogees;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Anomalies\Apogee;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Goniometry\Angle;

/**
 * Builds a Moon Apogees collection from raw ephemeris response.
 */
class FromArray extends Builder
{
    /**
     * The keys the array data must have.
     *
     * @var array
     */
    protected array $columns = [
        "timestamp",
        "longitude"
    ];

    /**
     * It constructs the builder with raw data.
     *
     * @param array $data
     * @throws InvalidArgumentException if the array data does not 
     * have keys "timestamp" and "longitude" or if the array is empty.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->validateData();
    }

    /**
     * Validates data.
     * 
     * @return void
     * @throws InvalidArgumentException if the array data does not 
     * have keys "timestamp" and "longitude" or if the array is empty.
     */
    protected function validateData()
    {
        $this->checkEmptyData();
        $this->validateArrayData($this->columns);
    }

    /**
     * Builds records.
     *
     * @return void
     */
    protected function buildRecords()
    {
        // Take the rows two by two and transform them in one row.
        $this->data = collect($this->data)->sliding(2, 2)->map(function ($pair) {
                $lines = $pair->all();
                $first_row = reset($lines);
                $last_row = end($lines);
            return [
                $first_row["timestamp"] /* timestamp */, 
                $first_row["longitude"], /* Moon longitude */
                $last_row["longitude"] /* apogee longitude */
            ];
        })->all();

        // Transform raw data in Moon ApogeeRecord instances.
        $timestamp = 0;
        $moon_longitude = 1;
        $apogee_longitude = 2;
        $this->data = collect($this->data)->transform(function($item) 
            use ($timestamp, $moon_longitude, $apogee_longitude){
                return new ApogeeRecord(
                    SwissEphemerisDateTime::createFromGregorianTT($item[$timestamp]),
                    Angle::createFromDecimal((float) $item[$moon_longitude]),
                    Angle::createFromDecimal((float) $item[$apogee_longitude])
                );
        })->all();

        // Select the correct Moon ApogeeRecord where the Moon is close to its apogee.
        $this->data = collect($this->data)->filter(function ($record) {
            /** @var ApogeeRecord $record */
            return new Apogee($record)->found();
        })->values()->all();
    }

    /**
     * Fetch the builded Moon ApogeeRecord instances.
     *
     * @return ApogeeRecord[]
     */
    public function fetchCollection(): array
    {
        if (!$this->builded) $this->buildRecords();
        return $this->data;
    }
}