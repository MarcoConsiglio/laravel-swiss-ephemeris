<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Perigees;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Builder;

/**
 * Builds an Apogees collection from a list of PerigeeRecord instances.
 */
class FromRecords extends Builder
{
    /**
     * Construct the builder with an array
     * of PerigeeRecord instances.
     *
     * @throws \InvalidArgumentException if at least
     * one element is not an PerigeeRecord.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->validateData();
    }


    /**
     * Validate data.
     *
     * @return void
     * @throws \InvalidArgumentException if at least one item is 
     * different than PerigeeRecord or no record is present.
     */
    protected function validateData()
    {
        $this->checkEmptyData();
        $this->validateRecords(PerigeeRecord::class);
    }

    /**
     * Builds records.
     *
     * @return void
     * @codeCoverageIgnore
     */
    protected function buildRecords()
    {
        // No need to build records.
    }

    /**
     * Fetches the result.
     */
    public function fetchCollection(): array
    {
        return $this->data;
    }
}