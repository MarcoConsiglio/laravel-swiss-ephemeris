<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Apogees;

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
     * The raw data used to create the Moon Apogees collection.
     *
     * @var array
     */
    protected $data;

    /**
     * The list of Moon ApogeeRecord instances.
     *
     * @var ApogeeRecord[]
     */
    protected array $records = [];
    
    /**
     * Construct the builder.
     *
     * @param $data The raw ephemeris response.
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
     * @throws \InvalidArgumentException if at least one 
     * item do not have the "timestamp" or "longitude" array key.
     */
    protected function validateData()
    {
        $this_class = self::class;
        $data = collect($this->data);
        $data->filter(function ($value) use ($this_class) {
            if(!isset($value["timestamp"])) {
                throw new InvalidArgumentException("The $this_class builder must have \"timestamp\" column.");    
            }
            if(!isset($value["longitude"])) {
                throw new InvalidArgumentException("The $this_class builder must have \"longitude\" column.");
            }
            return $value;
        });
    }

    /**
     * Builds records.
     *
     * @return void
     */
    protected function buildRecords()
    {
        // Take the rows two by two and transform them in one row.
        $two_rows_collection = collect($this->data)->sliding(2, 2)->toArray();
        $moon_and_apogee_raw_records = collect($two_rows_collection)->map(function ($row) {
                $first_row = reset($row);
                $last_row = end($row);
            return [
                $first_row["timestamp"] /* timestamp */, 
                $first_row["longitude"], /* Moon longitude */
                $last_row["longitude"] /* apogee longitude */
            ];
        })->all();
        $this->data = $moon_and_apogee_raw_records;

        // Transform raw data in Moon ApogeeRecord instances.
        $timestamp_index = 0;
        $moon_longitude_index = 1;
        $apogee_longitude_index = 2;
        $this->data = collect($this->data)->transform(function($item) 
            use ($timestamp_index, $moon_longitude_index, $apogee_longitude_index){
                return new ApogeeRecord(
                    SwissEphemerisDateTime::createFromGregorianTT($item[$timestamp_index]),
                    Angle::createFromDecimal((float) $item[$moon_longitude_index]),
                    Angle::createFromDecimal((float) $item[$apogee_longitude_index])
                );
        })->all();

        // Select the correct Moon ApogeeRecord where the Moon is close to its apogee.
        $this->data = collect($this->data)->transform(function ($record) {
            $apogee = new Apogee($record);
            return $apogee->found();
        })->filter()->all();
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