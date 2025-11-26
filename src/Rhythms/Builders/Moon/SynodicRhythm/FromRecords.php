<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Builder;

/**
 * Builds a Moon SynodicRhythm from an array of Moon SynodicRhythmRecord instances.
 */
class FromRecords extends Builder
{
    /**
     * It constructs the builder.
     *
     * @param array $data A list of MoonSynodicRecord(s).
     * @throws \InvalidArgumentException if at least one item is not a Moon SynodicRhythmRecord.
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
     * @throws \InvalidArgumentException if at least one item is 
     * different than SynodicRhythmRecord type or no record is present.
     */
    protected function validateData()
    {
        $this->checkEmptyData();
        $this->validateRecords(SynodicRhythmRecord::class);
    }

    /**
     * Build records.
     *
     * @return void
     * @codeCoverageIgnore
     */
    protected function buildRecords()
    {
        // No need to build records.
    }

    /**
     * Fetch the builded Moon SynodicRhythmRecord instances.
     *
     * @return SynodicRhythmRecord[]
     */
    public function fetchCollection(): array
    {
        return $this->data;
    }
}