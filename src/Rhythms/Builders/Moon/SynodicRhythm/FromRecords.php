<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;

/**
 * Builds a Moon SynodicRhythm from an array of Moon SynodicRhythmRecord instances.
 */
class FromRecords extends Builder
{
    /**
     * The data used to create the Moon SynodicRhythm collection.
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
     * Constructs the builder.
     *
     * @param array $data A list of MoonSynodicRecord(s).
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
     * @throws \InvalidArgumentException
     */
    public function validateData()
    {
        if (!is_array($this->data)) {
            throw new InvalidArgumentException("The builder ".self::class." must have array data.");
        }
        $collection = collect($this->data);
        $collection->filter(function ($item, $key) {
            if (!$item instanceof SynodicRhythmRecord) {
                throw new InvalidArgumentException(
                    "The builder ".self::class." must have an array of ".SynodicRhythmRecord::class."."
                );
            }
        });
    }

    /**
     * Build records.
     *
     * @return void
     * @codeCoverageIgnore
     */
    public function buildRecords()
    {
        // $this->data contains already the builded records.
    }

    /**
     * Fetch the builded Moon SynodicRhythm collection.
     *
     * @return SynodicRhythm
     */
    public function fetchCollection(): SynodicRhythm
    {
        return new SynodicRhythm($this->data);
    }
}