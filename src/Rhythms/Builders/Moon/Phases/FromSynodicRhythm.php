<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Phases;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Builder;
use MarcoConsiglio\Ephemeris\Enums\Moon\Phase;
use MarcoConsiglio\Ephemeris\Records\Moon\PhaseRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;

class FromSynodicRhythm extends Builder
{
    /**
     * The data used to create the MoonPhases collection.
     *
     * @var SynodicRhythm
     */
    protected SynodicRhythm $data;

    /**
     * The list of MoonPhaseType(s) used to filter the result.
     *
     * @var Phase[]
     */
    protected $moon_phase_types;
    
    /**
     * The MoonPhasesRecord(s).
     *
     * @var array
     */
    protected array $records;
    
    /**
     * Constructs the builder with a MoonSynodicRhythm and a list of MoonPhaseType(s).
     *
     * @param SynodicRhythm $synodic_rhythm
     * @param Phase[] $moon_phase_types The list of MoonPhaseType used to filter the 
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
            throw new InvalidArgumentException("The FromMoonSynodicRhythm MoonPhases builder needs at least a MoonPhaseType.");
        }
        foreach ($this->moon_phase_types as $phase) {
            if (! $phase instanceof Phase) {
                throw new InvalidArgumentException("Parameter 2 must be an array of ".Phase::class." but found ".gettype($phase)." inside.");
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
            /** @var \MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythmRecord $record */

            // Obtain all the strategies necessaries to filter the records, based upon
            // the $moon_phase_types passed into the constructur of this builder. This means 
            // that you can choose which moon phase or phases to use to filter your 
            // Moon synodic rhythm records.

            /** @var \Illuminate\Support\Collection $strategies */
            $strategies = collect($this->moon_phase_types)->transform(function ($item) {
                /** @var \MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType $items */
                return Phase::getCorrespondingStrategy($item);
            });

            // Each Moon synodic rhythm record is tested against each of the available strategies. 
            // If a strategy finds a useful Moon synodic rhythm record, it selects it for the 
            // purpose of building a moon phase record.

            /** @var string $strategy */
            foreach ($strategies as $strategy) {
                /** @var \MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\MoonPhaseStrategy $a_strategy */
                $a_strategy = new $strategy($record);
                if ($record_found = $a_strategy->found()) {
                    return new PhaseRecord($record_found->timestamp, Phase::getCorrespondingPhase($strategy));
                }
            }
            // return $moon_phase_records->first();
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