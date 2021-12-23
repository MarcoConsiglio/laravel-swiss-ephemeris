<?php
namespace MarcoConsiglio\Ephemeris\Rhythms;

use Illuminate\Support\Collection;

class MoonPeriods extends Collection
{
    public function __construct(SynodicRhythm $synodic_rhythm)
    {
        $periods = [];
        $prev_record = null;
        $waxing_period = [];
        $waning_period = [];
        foreach ($synodic_rhythm as $record) {
            /**
             * @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $record
             */
            /**
             * @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $prev_record
             */
            if ($prev_record) {
                // Check if it is the start of a waxing period.
                if ($record->isWaxing() && $prev_record->isWaning()) {
                    $waxing_period["start"] = $record->timestamp;
                    $waning_period["end"] = $prev_record->timestamp;
                }
                if ($record->isWaning() && $prev_record->isWaxing()) {
                    $waning_period["start"] = $record->timestamp;
                    $waxing_period["end"] = $prev_record->timestamp;
                }
            } else {
                if ($record->isWaxing()) {
                    $waxing_period["start"] = $record->timestamp;
                } elseif($record->isWaning()) {
                    $waning_period["start"] = $record->timestamp;
                }
            }
            if (array_key_exists("start", $waxing_period) && array_key_exists("end", $waxing_period)) {
                $periods[] = new MoonPeriod($waxing_period["start"], $waxing_period["end"], MoonPeriod::WAXING);
            }
            if (array_key_exists("start", $waning_period) && array_key_exists("end", $waning_period)) {
                $periods[] = new MoonPeriod($waning_period["start"], $waning_period["end"], MoonPeriod::WANING);
            }
            $prev_record = $record;
        }
        parent::__construct($periods);
    }
}