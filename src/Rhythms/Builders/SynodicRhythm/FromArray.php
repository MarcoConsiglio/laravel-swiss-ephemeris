<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\SynodicRhythm;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;

/**
 * Builds a SynodicRhythm from an array of raw values.
 */
class FromArray implements Builder
{
    /**
     * The data from which build a SynodicRhythm
     *
     * @var mixed
     */
    protected array $data;

    /**
     * The records of the SynodicRhythm.
     *
     * @var array
     */
    protected array $records = [];

    /**
     * Constructs the builder.
     *
     * @param mixed $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Validates data.
     *
     * @return void
     * @throws \InvalidArgumentException if passed data is not array with 'timestamp' and 'angular_distance' keys.
     */
    public function validateData()
    {
        if (empty($this->data)) {
            throw new InvalidArgumentException("The FromArray builder cannot work with an empty array.");
        }

        $records = collect($this->data);
        $records->filter(function ($value, $key) {
            if(!isset($value["timestamp"])) {
                throw new InvalidArgumentException("The FromArray builder must have 'timestamp' column.");    
            }
            if(!isset($value["angular_distance"])) {
                throw new InvalidArgumentException("The FromArray builder must have 'angular_distance' column.");
            }
            return $value;
        });
    }

    /**
     * Build records.
     *
     * @return void
     */
    public function buildRecords()
    {
        $records = collect($this->data);
        $records->transform(function ($item, $key) {
            return new SynodicRhythmRecord($item["timestamp"], (float) trim($item["angular_distance"]));
        });
        $this->records = $records->all();
    }

    /**
     * Fetch the builded collection.
     *
     * @return \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm
     */
    public function fetchCollection(): SynodicRhythm
    {
        return new SynodicRhythm($this->records);
    }
}