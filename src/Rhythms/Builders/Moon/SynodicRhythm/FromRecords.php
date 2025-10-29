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
     * A list of Moon SynodicRhythmRecord instances.
     *
     * @var SynodicRhythmRecord[]
     */
    protected array $data;

    /**
     * Constructs the builder.
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
     * @throws \InvalidArgumentException if at least one item is different than SynodicRhythmRecord.
     */
    protected function validateData()
    {
        $this_class = self::class;
        $collection = collect($this->data);
        $collection->filter(function ($item) use ($this_class){
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