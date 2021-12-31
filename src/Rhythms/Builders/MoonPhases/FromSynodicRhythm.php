<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;

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
        $collection = $this->data->filter(function ($record, $key) {
            /**
             * @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $record
             */
            $longitude = $record->angular_distance->toDecimal();
            return 
                $longitude == -180  ||
                $longitude == -90   ||
                $longitude == 0     ||
                $longitude == 90    ||
                $longitude == 180;
        });
        $ciao = "!";
    }

    public function fetchCollection()
    {
        
    }
}