<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Periods;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Builder;
use MarcoConsiglio\Ephemeris\Records\Moon\Period;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;

/**
 * Build a Moon Periods collection 
 * from the Moon SynodicRhythm collection.
 */
class FromSynodicRhythm extends Builder
{
    /**
     * The data used to create the collection.
     *
     * @var SynodicRhythm
     */
    protected $data;

    /**
     * The builded records.
     *
     * @var Period[]
     */
    protected array $records = [];

    /**
     * Constructs the builder with the Moon SynodicRhythm.
     *
     * @param SynodicRhythm $data
     */
    public function __construct(SynodicRhythm $data)
    {
        $this->data = $data;
    }

    /**
     * @return void
     * @codeCoverageIgnore
     */
    protected function validateData()
    {
        // No need to validate data.
    }

    /** 
     * Builds records of the MoonPeriods collection.
     *
     * @return void
     */
    public function buildRecords()
    {
        /** @var \Illuminate\Support\LazyCollection $records */
        // Divide the Moon synodic rhythm in waxing and waning Moon periods.
        $collection = collect($this->data->all());
        $this->records = $collection->chunkWhile(function ($record, $key, $chunk) {
            /** @var SynodicRhythmRecord $record */
            /** @var SynodicRhythm $chunk */
            // Separate all records in chunks of only waxing records and chunks of only waning records.
            return $record->isWaxing() === $chunk->last()->isWaxing();
        })->map(function ($period) {
            // Foreach period...
            /**
             * @var \Illuminate\Support\LazyCollection $period
             * @var SynodicRhythmRecord $first_record
             * @var SynodicRhythmRecord $last_record
             */
            $first_record = $period->first();
            $last_record = $period->last();
            // ...take the first and the last timestamp to build a MoonPeriod.
            return new Period($first_record->timestamp, $last_record->timestamp, $first_record->getPeriodType());
        })->all();
    }

    /**
     * Fetch the builded array of MoonPeriod(s).
     *
     * @return Period[]
     */
    public function fetchCollection(): array
    {
        $this->buildRecords();
        return $this->records;
    }
}