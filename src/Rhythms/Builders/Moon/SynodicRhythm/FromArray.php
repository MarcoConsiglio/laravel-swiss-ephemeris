<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Builder;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;

/**
 * Builds a Moon SynodicRhythm starting from an array of raw ephemeris response.
 */
class FromArray extends Builder
{
    /**
     * The data used to create the Moon SynodicRhythm collection.
     *
     * @var array
     */
    protected array $data;

    /**
     * The raw ephemeris response.
     *
     * @var array
     */
    protected array $records = [];

    /**
     * Constructs the builder with raw data.
     *
     * @param mixed $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->validateData();
    }

    /**
     * @return void
     * @throws \InvalidArgumentException if passed data is not array with 'timestamp' and 'angular_distance' keys.
     */
    public function validateData()
    {
        $this_class = self::class;
        if (empty($this->data)) {
            throw new InvalidArgumentException("The $this_class builder cannot work with an empty array.");
        }

        $records = collect($this->data);
        $records->filter(function ($value, $key) use ($this_class) {
            if(!isset($value["timestamp"])) {
                throw new InvalidArgumentException("The $this_class builder must have \"timestamp\" column.");    
            }
            if(!isset($value["angular_distance"])) {
                throw new InvalidArgumentException("The $this_class builder must have \"angular_distance\" column.");
            }
            return $value;
        });
    }

    /**
     * Build SynodicRhythmRecord instances.
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
     * Fetch the builded Moon SynodicRhythm collection.
     *
     * @return array
     */
    public function fetchCollection(): array
    {
        $this->buildRecords();
        return $this->records;
    }
}