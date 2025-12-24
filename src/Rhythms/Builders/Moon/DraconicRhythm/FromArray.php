<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\DraconicRhythm;

use MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\FromArrayBuilder;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Templates\Moon\DraconicTemplate;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Draconic\Node;

/**
 * Builds a DraconicRhythm from an array of raw ephemeris data.
 */
class FromArray extends FromArrayBuilder
{
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
        $this->columns = DraconicTemplate::getColumns();
        $this->validateData();
    }

    /**
     * Validate data.
     *
     * @return void
     * @throws \InvalidArgumentException if one or more columns 
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
                "moon_daily_speed" => $first_row["daily_speed"]
            ];
        })->all();

        // Transform raw data in Moon DraconicRecord instances.
        $this->data = collect($this->data)->transform(fn($item) => new DraconicRecord(
            SwissEphemerisDateTime::createFromGregorianTT($item["timestamp"]),
            Angle::createFromDecimal($item["moon_longitude"]),
            Angle::createFromDecimal($item["node_longitude"]),
            $item["moon_daily_speed"]
        ))->all();

        // Select the correct Moon DraconicRecord where the Moon is close to one of the two nodes.
        $this->data = collect($this->data)->filter(function ($record) {
            /** @var DraconicRecord $record */
            return new Node($record, $this->sampling_rate)->found();
        })->filter()->values()->all();
    }

    /**
     * Fetches the result.
     *
     * @return mixed
     */
    public function fetchCollection()
    {
        if (! $this->builded) $this->buildRecords();
        return $this->data;
    }
}