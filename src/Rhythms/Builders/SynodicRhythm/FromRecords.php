<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\SynodicRhythm;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;

/**
 * Builds a SynodicRhythm from an array of raw values.
 */
class FromRecords implements Builder
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
            throw new InvalidArgumentException("The builder FromRecords must have array data.");
        }
        $collection = collect($this->data);
        $collection->filter(function ($item, $key) {
            if (!$item instanceof SynodicRhythmRecord) {
                throw new InvalidArgumentException("The builder FromRecords must have an array of SynodicRhythmRecord.");
            }
        });
    }

    /**
     * Build records.
     *
     * @return void
     */
    public function buildRecords()
    {
        // $this->data contains already SynodicRhythmRecord(s).
    }

    /**
     * Fetch the builded collection.
     *
     * @return \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm
     */
    public function fetchCollection(): SynodicRhythm
    {
        return new SynodicRhythm($this->data);
    }
}