<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Perigees;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Builder;

/**
 * Builds an Apogees collection from a list of PerigeeRecord instances.
 */
class FromRecords extends Builder
{
    /**
     * The data used to build an Apogees collection.
     *
     * @var array
     */
    protected array $data;

    /**
     * Constructs the builder with an array
     * of PerigeeRecord instances.
     *
     * @param array $records
     * @throws InvalidArgumentException if at least 
     * one element is not an PerigeeRecord.
     */
    public function __construct(array $records)
    {
        $this->data = $records;
        $this->validateData();
    }

    /**
     * Validates data.
     *
     * @return void
     */
    protected function validateData()
    {
        $this_class = self::class;
        $collection = collect($this->data);
        $collection->filter(function ($item) use ($this_class){
            if (!$item instanceof PerigeeRecord) {
                throw new InvalidArgumentException(
                    "The builder $this_class must have an array of ".PerigeeRecord::class."."
                );
            }
        });
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