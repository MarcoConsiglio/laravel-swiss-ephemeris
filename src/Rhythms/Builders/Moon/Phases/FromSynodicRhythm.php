<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Phases;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Builder;
use MarcoConsiglio\Ephemeris\Enums\Moon\Phase;
use MarcoConsiglio\Ephemeris\Records\Moon\PhaseRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Phases;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\PhaseStrategy;

/**
 * @inheritDoc
 * Builds a Phase collection from a Moon SynodicRhythm.
 */
class FromSynodicRhythm extends Builder
{
    /**
     * The data used to create the Phases collection.
     *
     * @var SynodicRhythm
     */
    protected SynodicRhythm $data;

    /**
     * The list of Phase(s) used to filter the result.
     *
     * @var Phase[]
     */
    protected $moon_phases;
    
    /**
     * The PhasesRecord(s).
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
    public function __construct(SynodicRhythm $synodic_rhythm, array $moon_phases)
    {
        $this->data = $synodic_rhythm;  
        $this->moon_phases = $moon_phases;
        $this->validateData();
    }

    /**
     * Validates the list of Phase enum constants.
     *
     * @return void
     * @throws \InvalidArgumentException when at least one element of $moon_phase_types is not a MoonPhaseType.
     */
    public function validateData()
    {
        $this_class = self::class;
        $phase_class = Phase::class;
        $phases_collection = Phases::class;
        if (count($this->moon_phases) == 0) {
            throw new InvalidArgumentException("The $this_class builder needs at least a $phase_class enum constant to construct a $phases_collection collection.");
        }
        foreach ($this->moon_phases as $phase) {
            if (! $phase instanceof $phase_class) {
                throw new InvalidArgumentException("Parameter 2 must be an array of $phase_class but found ".gettype($phase)." inside.");
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
            /** @var SynodicRhythm $record */

            // Obtain all the strategies necessaries to filter the records, based upon
            // the $moon_phase_types passed into the constructur of this builder. This means 
            // that you can choose which moon phase or phases to use to filter your 
            // Moon synodic rhythm records.

            /** @var \Illuminate\Support\Collection $strategies */
            $strategies = collect($this->moon_phases)->transform(function ($item) {
                /** @var Phase $items */
                return Phase::getCorrespondingStrategy($item);
            });

            // Each Moon synodic rhythm record is tested against each of the available strategies. 
            // If a strategy finds a useful Moon synodic rhythm record, selects it for the 
            // purpose of building a moon phase record.

            /** @var string $strategy */
            foreach ($strategies as $strategy) {
                /** @var PhaseStrategy $a_strategy */
                $a_strategy = new $strategy($record);
                if ($record_found = $a_strategy->found()) {
                    return new PhaseRecord($record_found->timestamp, Phase::getCorrespondingPhase($strategy));
                }
            }
        })->filter()->all();
    }

    /**
     * Returns an array of PhaseRecord(s).
     *
     * @return PhaseRecord[]
     */
    public function fetchCollection(): array
    {
        $this->buildRecords();
        return $this->records;
    }
}