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
use MarcoConsiglio\Ephemeris\Rhythms\MoonPhaseRecord;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPhases;

class FromSynodicRhythm implements Builder
{
    /**
     * The data used to create the MoonPhases collection.
     *
     * @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm
     */
    protected \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm $data;

    /**
     * The list of strategies used to find a MoonPhaseRecord.
     *
     * @var array
     */
    protected array $moon_phase_strategies;
    
    /**
     * The MoonPhasesRecord(s).
     *
     * @var array
     */
    protected array $records;
    
    /**
     * Constructs the builder with a SynodicRhythm and a list of MoonPhaseStrategy concrete classes.
     *
     * @param \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm $synodic_rhythm
     * @param array                                           $moon_phase_strategies The list of MoonPhaseStrategy classes filters
     * the result of the builder. The builder needs at least one strategy.
     * @throws \InvalidArgumentException when there is no moon phase strategies or an unxpected class.
     */
    public function __construct(SynodicRhythm $synodic_rhythm, array $moon_phase_strategies)
    {
        $this->data = $synodic_rhythm;    
        $this->moon_phase_strategies = $moon_phase_strategies;
        $this->validateData();
    }

    /**
     * Validates the list of MoonPhaseStrategy classes.
     *
     * @return void
     * @throws \InvalidArgumentException when there is no moon phase strategies or an unxpected class.
     */
    public function validateData()
    {
        if (count($this->moon_phase_strategies) == 0) {
            throw new InvalidArgumentException("The FromSynodicRhythm MoonPhases builder needs at least of one MoonPhaseStrategy class.");
        }
        foreach ($this->moon_phase_strategies as $strategy) {
            if (get_parent_class($strategy) !== MoonPhaseStrategy::class) {
                throw new InvalidArgumentException("The FromSynodicRhythm MoonPhases builder needs only MoonPhaseStrategy classes.");
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
            $strategies = collect($this->moon_phase_strategies);
            $records = $strategies->map(function ($strategy, $index) use ($record) {
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