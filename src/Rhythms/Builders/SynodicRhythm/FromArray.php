<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\SynodicRhythm;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\SynodicRhythm\Interfaces\SynodicRhythmBuilder;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;

/**
 * Builds a SynodicRhythm from an array of raw values.
 */
class FromArray implements SynodicRhythmBuilder
{
    /**
     * The data from which build a SynodicRhythm
     *
     * @var mixed
     */
    protected $data;

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
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Validates data.
     *
     * @return void
     * @throws \InvalidArgumentException
     */
    public function validateData()
    {
        if (!is_array($this->data)) {
            throw new InvalidArgumentException("The SynodicRhythmBuilder FromArray must have array data.");
        }
        foreach ($this->data as $index => $item) {
            if(!isset($item["timestamp"]) || !isset($item["angular_distance"])) {
                throw new InvalidArgumentException("The SynodicRhythmBuilder FromArray must have data array with 'timestamp' and 'angular_distance'");
            }
        }
    }

    public function buildRecords()
    {
        foreach ($this->data as $item) {
            $this->records[] = new SynodicRhythmRecord($item["timestamp"], (float) trim($item["angular_distance"]));
        }
    }

    public function fetchCollection()
    {
        return new SynodicRhythm($this->records);
    }
}