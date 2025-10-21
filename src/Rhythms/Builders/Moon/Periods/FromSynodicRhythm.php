<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Periods;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Period;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPeriod;
use MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythm;

/**
 * Build a MoonPeriods collection starting from the MoonSynodicRhythm.
 */
class FromSynodicRhythm extends Builder
{
    /**
     * The data used to create the collection.
     *
     * @var \MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythm
     */
    protected $data;

    /**
     * The builded records.
     *
     * @var array
     */
    protected array $items = [];

    /**
     * Constructs the builder with the MoonSynodicRhythm.
     *
     * @param SynodicRhythm $data
     */
    public function __construct(SynodicRhythm $data)
    {
        $this->data = $data;
    }

    /**
     * Validates data.
     *
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
        /** @var \Illuminate\Support\LazyCollection $periods */
        // Divide MoonSynodicRhythm in waxing and waning moon periods.
        $periods = $this->data->chunkWhile(function ($record, $key, $chunk) {
            /** @var \MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythmRecord $record */
            // Separate all records in chunks of only waxing records and chunks of only waning records.
            return $record->isWaxing() === $chunk->last()->isWaxing();
        })->all();

        // For each period...
        $this->items = $periods->map(function ($period, $key) {
            /**
             * @var \Illuminate\Support\LazyCollection $period
             * @var \MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythmRecord $first_record
             * @var \MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythmRecord $last_record
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
     * @return array
     */
    public function fetchCollection(): array
    {
        $this->buildRecords();
        return $this->items;
    }
}