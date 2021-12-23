<?php
namespace MarcoConsiglio\Ephemeris\Rhythms;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\WaxingMoonPeriods;
use MarcoConsiglio\Trigonometry\Angle;

class SynodicRhythm extends Collection
{
    /**
     * Create a new SynodicRhythm.
     *
     * @param array $items
     */
    public function __construct($items)
    {
        // 
        $records = [];
        $self = self::class;
        foreach ($items as $item) {
            if ($item instanceof SynodicRhythmRecord) {
                $records[] = $item;
                continue;
            }
            if (is_array($item) && isset($item["timestamp"]) && isset($item["angular_distance"])) {
                $records[] = new SynodicRhythmRecord($item["timestamp"], (float) trim($item["angular_distance"]));
                continue;
            }
            throw new InvalidArgumentException("The SynodicRhythm must be constructed with SynodicRhythmRecord(s) or an array with 'timestamp' and 'angular_distance' setted.");
        }
        if (!empty($items)) {
            $this->items = $records;
        } else {
            throw new InvalidArgumentException("The SynodicRhythm must be constructed with SynodicRhythmRecord(s) or an array with 'timestamp' and 'angular_distance' setted.");
        }
    }

    /**
     * Tells if a specific SynodicRhythm record is referred to
     * a waxing moon.
     *
     * @param mixed $key
     * @return boolean
     * @throws \InvalidArgumentException if $key is not of int or Carbon type.
     */
    public function isWaxing($key)
    {
        if (is_int($key)) {
            $record = $this->get($key);
            return $record->isWaxing();
        }
        if ($key instanceof CarbonInterface) {
            $timestamps = collect($this->items)->map(function ($item) {
                /**
                 * @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $item
                 */
                return $item->timestamp;
            });
            $numeric_key = array_search($key, $timestamps->all(), true);
            $record = $this->get($numeric_key);
            return $record->isWaxing();
        }
        throw new InvalidArgumentException("Expected type are int or Carbon, but ".gettype($key)." found.");
    }

    /**
     * Gets a SynodicRhythmRecord from the collection by key.
     *
     * @param  mixed  $key
     * @param  mixed  $default
     * @return \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord
     */
    public function get($key, $default = null): SynodicRhythmRecord
    {
        return parent::get($key, $default = null);
    }

    /**
     * Gets a collection of MoonPeriods.
     *
     * @return \MarcoConsiglio\Ephemeris\Rhythms\MoonPeriods
     */
    public function getPeriods()
    {
        return new MoonPeriods($this);
    }
}