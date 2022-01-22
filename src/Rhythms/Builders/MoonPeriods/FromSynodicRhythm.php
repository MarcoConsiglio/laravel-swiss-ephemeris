<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPeriods;

use Illuminate\Support\LazyCollection;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPeriod;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPeriods;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;

/**
 * Build a MoonPeriods collection starting from the SynodicRhythm.
 */
class FromSynodicRhythm implements Builder
{
    /**
     * The data used to create the collection.
     *
     * @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm
     */
    protected $data;

    /**
     * The builded records.
     *
     * @var array
     */
    protected array $items = [];

    /**
     * Constructs the builder with the SynodicRhythm.
     *
     * @param \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm $data
     */
    public function __construct(SynodicRhythm $data)
    {
        $this->data = $data;
        $this->validateData();
    }

    /**
     * Validates data.
     *
     * @return void
     * @codeCoverageIgnore
     */
    public function validateData()
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
        /**
         * @var \Illuminate\Support\LazyCollection $periods
         */
        // Divide SynodicRhythm in waxing and waning moon periods.
        $periods = $this->data->chunkWhile(function ($record, $key, $chunk) {
            /**
             * @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $record
             */
            return $record->isWaxing() === $chunk->last()->isWaxing();
        })->all();

        // For each period...
        $this->items = $periods->map(function ($period, $key) {
            /**
             * @var \Illuminate\Support\LazyCollection $period
             */
            /**
             * @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $first_record
             */
            /**
             * @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $last_record
             */
            $first_record = $period->first();
            $last_record = $period->last();
            // ...take the first and the last timestamp to build a MoonPeriod.
            return new MoonPeriod($first_record->timestamp, $last_record->timestamp, $first_record->getType());

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