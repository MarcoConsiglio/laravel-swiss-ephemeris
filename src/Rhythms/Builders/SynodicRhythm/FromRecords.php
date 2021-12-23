<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\SynodicRhythm;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\SynodicRhythm\Interfaces\SynodicRhythmBuilder;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;

/**
 * Builds a SynodicRhythm from an array of raw values.
 */
class FromRecords implements SynodicRhythmBuilder
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
            throw new InvalidArgumentException("The SynodicRhythmBuilder FromRecords must have array data.");
        }
        foreach ($this->data as $item) {
            if (!$item instanceof SynodicRhythmRecord) {
                throw new InvalidArgumentException("The SynodicRhythmBuilder FromRecords must have an array of SynodicRhythmRecord.");
            }
        }
    }

    public function buildRecords()
    {
        // $this->data contains already SynodicRhythmRecord(s).
    }

    public function fetchCollection()
    {
        return new SynodicRhythm($this->data);
    }
}