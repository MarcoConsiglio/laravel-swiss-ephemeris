<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Apogees;
use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Builder;

/**
 * Builds an Apogees collection from a list of ApogeeRecord instances.
 */
class FromRecords extends Builder
{
    /**
     * It constructs the builder with an array
     * of ApogeeRecord instances.
     *
     * @param array $data
     * @throws InvalidArgumentException if at least 
     * one element is not an ApogeeRecord or the 
     * array data is empty.
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
     */
    protected function validateData()
    {
        $this->checkEmptyData();
        $this->validateRecords(ApogeeRecord::class);
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
     *
     * @return array
     */
    public function fetchCollection(): array
    {
        return $this->data;
    }
}