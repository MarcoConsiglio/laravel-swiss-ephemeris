<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\DraconicRhythm;

use MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\FromArrayBuilder;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Templates\Moon\DraconicTemplate;
use MarcoConsiglio\Goniometry\Angle;

class FromArray extends FromArrayBuilder
{
    /**
     * The keys the array data must have.
     *
     * @var array
     */
    protected array $columns = [
        0 => "timestamp",
        1 => "longitude",
        2 => "latitude",
        3 => "daily_speed"        
    ];

    /**
     * It constructs the builder with raw data.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->columns = DraconicTemplate::getColumns();
        $this->validateData();
    }

    /**
     * Validates data.
     *
     * @return void
     * @throws InvalidArgumentException if one or more columns 
     * are missing from the data passed to the builder.
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
                "timestamp" => $first_row["timestamp"],
                "moon_longitude" => $first_row["longitude"],
                "node_longitude" => $last_row["longitude"],
                "moon_latitude" => $first_row["latitude"],
                "moon_daily_speed" => $first_row["daily_speed"]
            ];
        })->all();

        // Transform raw data in Moon DraconicRecord instances.
        $this->data = collect($this->data)->transform(function ($item) {
            $opposite = Angle::createFromValues(180, direction: Angle::CLOCKWISE);
            return new DraconicRecord(
                SwissEphemerisDateTime::createFromGregorianTT($item["timestamp"]),
                Angle::createFromDecimal($item["moon_longitude"]),
                Angle::createFromDecimal($item["moon_latitude"]),
                $node_longitude = Angle::createFromDecimal($item["node_longitude"]),
                Angle::sum($node_longitude, $opposite),
                $item["moon_daily_speed"]
            );
        })->all();

        // Select the correct Moon DraconicRecord where the Moon is close to one of the two nodes.
        $this->data = collect($this->data)->filter(function ($record) {
            return new Node($record, $this->sampling_rate)->found();
        })->values()->all();
    }

    /**
     * Fetches the result.
     *
     * @return mixed
     */
    public function fetchCollection()
    {
        
    }
}