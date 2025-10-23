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
     * @var array
     */
    protected $data;

    /**
     * A list of SynodicRhythmRecord instances.
     *
     * @var SynodicRhythmRecord[]
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
        $this->records = $this->data;
    }

    /**
     * Validates data.
     *
     * @return void
     * @throws \InvalidArgumentException if at least one item is different than SynodicRhythmRecord.
     */
    public function validateData()
    {
        $this_class = self::class;
        if (!is_array($this->data)) {
            throw new InvalidArgumentException("The builder $this_class must have array data.");
        }
        $collection = collect($this->data);
        $collection->filter(function ($item, $key) use ($this_class){
            if (!$item instanceof SynodicRhythmRecord) {
                throw new InvalidArgumentException(
                    "The builder $this_class must have an array of ".SynodicRhythmRecord::class."."
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
     * Fetch the builded Moon SynodicRhythmRecord instances.
     *
     * @return SynodicRhythmRecord[]
     */
    public function fetchCollection(): array
    {
        return $this->records;
    }
}