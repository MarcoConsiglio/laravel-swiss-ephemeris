<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Apogees;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\FromArrayBuilder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Anomalies\Apogee;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Goniometry\Angle;

/**
 * Builds a Moon Apogees collection from raw Swiss Ephemeris response.
 */
class FromArray extends FromArrayBuilder
{
    /**
     * The keys the array data must have.
     *
     * @var array
     */
    protected array $columns = [
        "timestamp",
        "longitude",
        "daily_speed"
    ];

    /**
     * Construct the builder with raw data.
     *
     * @param array $data
     * @param int $sampling_rate The sampling rate of the ephemeris 
     * expressed in minutes per each step of the ephemeris response.
     * @throws \InvalidArgumentException if one or more columns 
     * are missing from the data passed to the builder.
     */
    public function __construct(array $data, int $sampling_rate)
    {
        $this->data = $data;
        $this->sampling_rate = abs($sampling_rate);
        $this->validateData();
    }

    /**
     * Validate data.
     * 
     * @return void
     * @throws \InvalidArgumentException if the array data does not 
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
                "timestamp" => $first_row["timestamp"] /* timestamp */, 
                "moon_longitude" => $first_row["longitude"], /* Moon longitude */
                "apogee_longitude" => $last_row["longitude"], /* apogee longitude */
                "moon_daily_speed" => $first_row["daily_speed"] /* Moon daily speed */
            ];
        })->all();

        // Transform raw data in Moon ApogeeRecord instances.
        $this->data = collect($this->data)->transform(function($item) {
                return new ApogeeRecord(
                    SwissEphemerisDateTime::createFromGregorianTT($item["timestamp"]),
                    Angle::createFromDecimal((float) $item["moon_longitude"]),
                    Angle::createFromDecimal((float) $item["apogee_longitude"]),
                    (float) $item["moon_daily_speed"]
                );
        })->all();

        // Select the correct Moon ApogeeRecord where the Moon is close to its apogee.
        $this->data = collect($this->data)->filter(function ($record) {
            /** @var ApogeeRecord $record */
            return new Apogee($record, $this->sampling_rate)->found();
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