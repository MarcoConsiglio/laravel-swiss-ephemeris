<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Perigees;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\FromArrayBuilder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Anomalies\Perigee;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Templates\Moon\AnomalisticTemplate;
use MarcoConsiglio\Goniometry\Angle;

/**
 * Builds a Moon Perigees collection from raw ephemeris response.
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
        $this->sampling_rate = $sampling_rate;
        $this->columns = AnomalisticTemplate::getColumns();
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
        // Take the rows two by two.
        $this->data = collect($this->data)->sliding(2, 2)->map(function ($pair) {
                $lines = $pair->all();
                $first_row = reset($lines);
                $last_row = end($lines);
            return [
                "timestamp" => $first_row["timestamp"] , 
                "moon_longitude" => $first_row["longitude"],
                "perigee_longitude" => $last_row["longitude"],
                "moon_daily_speed" => $first_row["daily_speed"]
            ];
        })->all();

        // Transform raw data in Moon PerigeeRecord instances.
        $this->data = collect($this->data)->transform(fn($item) => new PerigeeRecord(
            SwissEphemerisDateTime::createFromGregorianTT($item["timestamp"]),
            Angle::createFromDecimal((float) $item["moon_longitude"]),
            Angle::createFromDecimal((float) $item["perigee_longitude"]),
            (float) $item["moon_daily_speed"]
        ))->all();

        // Select the correct Moon PerigeeRecord where the Moon is close to its perigee.
        $this->data = collect($this->data)->filter(function ($record) {
            /** @var PerigeeRecord $record */
            $perigee = new Perigee($record, $this->sampling_rate);
            return $perigee->found();
        })->values()->all();
    }

    /**
     * Fetch the builded Moon PerigeeRecord instances.
     *
     * @return PerigeeRecord[]
     */
    public function fetchCollection(): array
    {
        if (!$this->builded) $this->buildRecords();
        return $this->data;
    }
}