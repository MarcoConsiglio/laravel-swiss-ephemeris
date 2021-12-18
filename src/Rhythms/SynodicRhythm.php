<?php
namespace MarcoConsiglio\Ephemeris\Rhythms;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\WaxingMoonPeriods;

class SynodicRhythm extends Collection
{
    /**
     * Waxing Moon periods.
     *
     * @var \lluminate\Support\Collection
     */
    protected static Collection $waxing_periods;

    /**
     * Create a new SynodicRhythm.
     *
     * @param  mixed  $items
     * @return void
     */
    public function __construct($items = [])
    {
        return parent::__construct($items);
    }

    /**
     * Tells if a specific SynodicRhythm record is referred to
     * a waxing moon.
     *
     * @param mixed $key
     * @return boolean
     */
    public function isWaxing($key)
    {
        if (is_int($key)) {
            $record = $this->get($key);
            return $record["percentage"] >= 0;
        }
        if ($key instanceof CarbonInterface) {
            $numeric_key = array_search($key, $this->pluck("timestamp")->all(), true);
            $record = $this->get($numeric_key);
            return $record["percentage"] >= 0;
        }
        throw new InvalidArgumentException("Expected type are int or Carbon, but ".gettype($key)." found.");
    }

    public function getWaxingPeriods()
    {
        return new WaxingMoonPeriods ($this);
    }
}