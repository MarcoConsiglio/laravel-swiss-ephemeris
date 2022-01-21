<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\FirstQuarter;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\FullMoon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\MoonPhaseStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\NewMoon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\ThirdQuarter;
use MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPhaseRecord;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPhases;
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
     * The list of MoonPhaseType(s) used to filter the result.
     *
     * @var array
     */
    protected array $moon_phase_types;
    
    /**
     * The MoonPhasesRecord(s).
     *
     * @var array
     */
    protected array $records;
    
    /**
     * Constructs the builder with a SynodicRhythm and a list of MoonPhaseType(s).
     *
     * @param \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm $synodic_rhythm
     * @param array[\MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType] $moon_phase_types The list of MoonPhaseType used to filter the 
     * the result of the builder. The builder needs at least one MoonPhaseType.
     * @throws \InvalidArgumentException when at least one element of $moon_phase_types is not a MoonPhaseType.
     */
    public function __construct(SynodicRhythm $synodic_rhythm, array $moon_phase_types)
    {
        $this->data = $synodic_rhythm;  
        $this->moon_phase_types = $moon_phase_types;
        $this->validateData();
    }

    /**
     * Validates the list of MoonPhaseStrategy classes.
     *
     * @return void
     * @throws \InvalidArgumentException when at least one element of $moon_phase_types is not a MoonPhaseType.
     */
    public function validateData()
    {
        if (count($this->moon_phase_types) == 0) {
            throw new InvalidArgumentException("The FromSynodicRhythm MoonPhases builder needs at least a MoonPhaseType.");
        }
        foreach ($this->moon_phase_types as $phase) {
            if (! $phase instanceof MoonPhaseType) {
                throw new InvalidArgumentException("Parameter 2 must be an array of ".MoonPhaseType::class." but found ".gettype($phase)." inside.");
            }
        }
    }

    /**
     * Builds the MoonPhasesRecord(s).
     *
     * @return void
     */
    public function buildRecords()
    {
        $this->records = $this->data->transform(function ($record, $key) {
            /** @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $record */
            $strategies = collect($this->moon_phase_types)->transform(function ($item) {
                /** @var \MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType $items */
                return MoonPhaseType::getCorrespondingStrategy($item);
            });
            $records = $strategies->map(function ($strategy) use ($record) {
                /** @var string $strategy */
                /** @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $chosen */
                if ($chosen = (new $strategy($record))->found()) {
                    return new MoonPhaseRecord($chosen->timestamp, MoonPhaseType::getCorrespondingType($strategy));
                } 
                return false;
            });
            return $records->first();
        })->filter()->all();
    }

    /**
     * Returns an array of MoonPhaseRecord(s).
     *
     * @return array
     */
    public function fetchCollection(): array
    {
        $this->buildRecords();
        return $this->records;
    }
}