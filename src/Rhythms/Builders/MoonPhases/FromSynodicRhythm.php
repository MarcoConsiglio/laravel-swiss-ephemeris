<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\FirstQuarter;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\FullMoon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\NewMoon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\ThirdQuarter;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPhaseRecord;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType;

class FromSynodicRhythm implements Builder
{
    /**
     * The data used to create the MoonPhases collection.
     *
     * @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm
     */
    protected \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm $data;
    
    /**
     * The records of the MoonPhases collection.
     *
     * @var array
     */
    protected array $records;
    
    public function __construct(SynodicRhythm $synodic_rhythm)
    {
        $this->data = $synodic_rhythm;    
    }

    public function validateData()
    {
        // No need to validate data.
    }

    public function buildRecords()
    {
        $this->records = $this->data->transform(function ($record, $key) {
            /**
             * @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $record
             */
            if ($chosen = (new NewMoon($record))->findRecord()) {
                return new MoonPhaseRecord($chosen->timestamp, MoonPhaseType::NewMoon);
            }
            if ($chosen = (new FirstQuarter($record))->findRecord()) {
                return new MoonPhaseRecord($chosen->timestamp, MoonPhaseType::FirstQuarter);
            }
            if ($chosen = (new FullMoon($record))->findRecord()) {
                return new MoonPhaseRecord($chosen->timestamp, MoonPhaseType::FullMoon);
            }
            if ($chosen = (new ThirdQuarter($record))->findRecord()) {
                return new MoonPhaseRecord($chosen->timestamp, MoonPhaseType::ThirdQuarter);
            }
            return false;
        })->all();
    }

    public function fetchCollection()
    {
        return new MoonPhases($this->records);
    }
}