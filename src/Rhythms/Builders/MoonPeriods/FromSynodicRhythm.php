<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPeriods;

use Illuminate\Support\LazyCollection;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPeriod;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPeriods;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;

class FromSynodicRhythm implements Builder
{
    /**
     * The data The data used to create the collection.
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

    public function __construct(SynodicRhythm $data)
    {
        $this->data = $data;
    }

    /**
     * Validates data.
     *
     * @return void
     */
    public function validateData()
    {
        
    }

    /**
     * Builds records.
     *
     * @return void
     */
    public function buildRecords()
    {
        $periods = $this->data->chunkWhile(function ($record, $key, $chunk) {
            /**
             * @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $record
             */
            return $record->isWaxing() === $chunk->last()->isWaxing();
        })->all();
        /**
         * @var \Illuminate\Support\LazyCollection $periods
         */
        $this->items = $periods->map(function ($period, $key) {
            /**
             * @var \Illuminate\Support\LazyCollection $period
             */
            /**
             * @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $first_record
             */
            $first_record = $period->first();
            /**
             * @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $last_record
             */
            $last_record = $period->last();
            return new MoonPeriod($first_record->timestamp, $last_record->timestamp, $first_record->getType());

        })->all();    
    }

    /**
     * Fetch the builded collection.
     *
     * @return \MarcoConsiglio\Ephemeris\Rhythms\MoonPeriods
     */
    public function fetchCollection()
    {
        return new MoonPeriods($this->items);
    }
}