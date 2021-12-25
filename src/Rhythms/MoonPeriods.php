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
        if ($synodic_rhythm->isNotEmpty()) {
            foreach ($synodic_rhythm as $record) {
                /**
                 * @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $record
                 */
                /**
                 * @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $prev_record
                 */
                if ($prev_record) {
                    // Check if it is the start of a waxing period.
                    if ($this->isStartingWaxingPeriod($record, $prev_record)) {
                        $waxing_period["start"] = $record->timestamp;
                        $waning_period["end"] = $prev_record->timestamp;
                    }
                    if ($this->isStartingWaningPeriod($record, $prev_record)) {
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
                if ($this->wasAPeriodFound($waxing_period)) {
                    $periods[] = $this->createMoonPeriod($waxing_period, MoonPeriod::WAXING);
                }
                if ($this->wasAPeriodFound($waning_period)) {
                    $periods[] = $this->createMoonPeriod($waning_period, MoonPeriod::WANING);
                }
                $prev_record = $record;
            }
            parent::__construct($periods);
        }
    }

    private function isStartingWaxingPeriod(SynodicRhythmRecord $current_record, SynodicRhythmRecord $previous_record)
    {
        return $current_record->isWaxing() && $previous_record->isWaning();
    }

    private function isStartingWaningPeriod(SynodicRhythmRecord $current_record, SynodicRhythmRecord $previous_record)
    {
        return $current_record->isWaning() && $previous_record->isWaxing();
    }

    private function wasAPeriodFound(array $period)
    {
        return array_key_exists("start", $period) && array_key_exists("end", $period);
    }

    private function createMoonPeriod(array $period, int $type): MoonPeriod
    {
        return new MoonPeriod($period["start"], $period["end"], $type);
    }
}