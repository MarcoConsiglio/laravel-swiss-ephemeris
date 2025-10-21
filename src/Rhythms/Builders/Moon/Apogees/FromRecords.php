<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Apogees;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Apogees;
use MarcoConsiglio\Ephemeris\Rhythms\MoonApogees;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Goniometry\Angle;

/**
 * Builds a MoonApogees collection.
 */
class FromRecords extends Builder
{
    /**
     * The data used to create the MoonApogees collection.
     *
     * @var mixed
     */
    protected $data;

    /**
     * The list of MoonApogeeRecord.
     *
     * @var array
     */
    protected array $records = [];
    
    /**
     * Construct the builder.
     *
     * @param array $data A list of MoonApogeesRecord(s).
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
     * @throws \InvalidArgumentException if at least one item is not a MoonApogeeRecord.
     */
    protected function validateData()
    {
        if (!is_array($this->data)) {
            throw new InvalidArgumentException("The builder ".self::class." must have array data.");
        }
    }

    protected function buildRecords()
    {
        // Take the rows two by two.
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

        // Transform raw data in MoonApogeeRecord(s).
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
        $stop_here = "";
        // Select the correct MoonApogeeRecord where the Moon is close to its apogee.
    }

    /**
     * Fetch the builded MoonApogees collection.
     *
     * @return Apogees
     */
    public function fetchCollection(): Apogees
    {
        $this->buildRecords();
        return new Apogees($this->data);
    }
}