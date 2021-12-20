<?php
namespace MarcoConsiglio\Ephemeris\Rhythms;

use Illuminate\Support\Collection;

class WaxingMoonPeriods extends Collection
{
    /**
     * Create a new collection of waxing moon periods.
     *
     * @param \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm $synodic_rhythm
     * @return void
     */
    public function __construct(SynodicRhythm $synodic_rhythm)
    {
        $waxing_periods = [];
        $prev_record = null;
        $period = [];
        foreach ($synodic_rhythm as $record) {
            /**
             * @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $record
             */
            if ($prev_record) {
                if ($record->isWaxing() && $prev_record->isWaning()) {
                    $period["start_timestamp"] = $record->timestamp;
                }
                if ($record->isWaning() && $prev_record->isWaxing()) {
                    $period["end_timestamp"] = $prev_record->timestamp;
                }
            } else {
                if ($record->isWaxing()) {
                    $period["start_timestamp"] = $record->timestamp;
                }
            }
            if (array_key_exists("start_timestamp", $period) && array_key_exists("end_timestamp", $period)) {
                $waxing_periods[] = new WaxingMoonPeriod($period["start_timestamp"], $period["end_timestamp"]);
                $period = [];
            }
            $prev_record = $record;      
        }
        parent::__construct($waxing_periods);
    }
}