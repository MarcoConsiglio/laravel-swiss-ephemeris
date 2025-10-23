<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Moon;

use Illuminate\Support\Collection;
use UnexpectedValueException;
use Illuminate\Support\LazyCollection;
use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Periods\FromSynodicRhythm as MoonPeriodBuilder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Phases\FromSynodicRhythm as MoonPhasesBuilder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromRecords;
use stdClass;

/**
 * A collection of SynodicRhythmRecord instances.
 * 
 * Represents the Moon's synodic rhythm over a time range. 
 * A Moon synodic rhythm, or synodic period, is the time it takes 
 * for a celestial object to return to the same position 
 * relative to the Sun, as seen from the Earth.
 */
class SynodicRhythm extends Collection
{
    /**
     * Create a new MoonSynodicRhythm.
     *
     * @param FromArray|FromRecords $items
     */
    public function __construct(FromArray|FromRecords $builder)
    {
        $this->items = $builder->fetchCollection(); 
    }

    /**
     * Gets a Moon SynodicRhythmRecord from the collection by key.
     *
     * @param  mixed  $key
     * @param  mixed  $default
     * @return SynodicRhythmRecord
     */
    public function get($key, $default = null): SynodicRhythmRecord
    {
        return parent::get($key, $default = null);
    }

    /**
     * Gets a collection of Moon Periods.
     *
     * @return Periods
     */
    public function getPeriods(): Periods
    {
        return new Periods(new MoonPeriodBuilder($this));
    }

    /**
     * Gets a collection of MoonPhases.
     *
     * @param array $moon_phase_types An array ofMoonPhaseType
     * items representing which moon phases you want to extract.
     * @return Phases
     */
    public function getPhases(array $moon_phase_types): Phases
    {
        return new Phases(new MoonPhasesBuilder($this, $moon_phase_types));
    }

    /**
     * Gets the first MoonSynodicRhythmRecord.
     *
     * @param callable|null $callback
     * @param mixed $default
     * @return SynodicRhythmRecord
     */
    public function first(?callable $callback = null, $default = null): SynodicRhythmRecord
    {
        if ($this->items instanceof LazyCollection) {
            return $this->items->first($callback, $default);
        }
        return parent::first($callback, $default);
    }

    /**
     * Gets the last MoonSynodicRhythmRecord.
     *
     * @param callable|null $callback
     * @param mixed        $default
     * @return SynodicRhythmRecord
     */
    public function last(?callable $callback = null, $default = null): SynodicRhythmRecord
    {
        if ($this->items instanceof LazyCollection) {
            return $this->items->last($callback, $default);
        }
        return parent::last($callback, $default);
    }

    /**
     * Check that all items in $array are instances of type
     * SynodicRhythmRecord.
     *
     * @param array $array
     * @return void
     * @throws UnexpectedValueException
     */
    protected function arrayContainsType(array $array, string $type): void
    {
        collect($array)->ensure($type);        
    }

    /**
     * Check that all items in $array are of type string.
     *
     * @param array $array
     * @return void
     */
    protected function arrayContainsString(array $array): void
    {
        collect($array)->ensure("string");
    }
}