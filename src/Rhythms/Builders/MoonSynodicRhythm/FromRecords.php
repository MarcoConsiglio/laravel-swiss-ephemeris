<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonSynodicRhythm;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythmRecord;

/**
 * Builds a MoonSynodicRhythm from an array of MoonSynodicRhythmRecord(s).
 */
class FromRecords implements Builder
{
    /**
     * The data used to create the MoonSynodicRhythm collection.
     *
     * @var mixed
     */
    protected $data;

    /**
     * The records of the MoonSynodicRhythm.
     *
     * @var array
     */
    protected array $records = [];

    /**
     * Constructs the builder with an array of SynodiRhythmRecord(s).
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
            if (!$item instanceof MoonSynodicRhythmRecord) {
                throw new InvalidArgumentException("The builder FromRecords must have an array of MoonSynodicRhythmRecord.");
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
        // $this->data contains already MoonSynodicRhythmRecord(s).
    }

    /**
     * Fetch the builded MoonSynodicRhythm collection.
     *
     * @return \MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythm
     */
    public function fetchCollection(): MoonSynodicRhythm
    {
        return new MoonSynodicRhythm($this->data);
    }
}