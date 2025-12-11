<?php
namespace MarcoConsiglio\Ephemeris\Records;

use MarcoConsiglio\Ephemeris\Traits\StringableRecord;
use Stringable;

/**
 * It defines the abstract concept of a record of the 
 * ephemeris of a celestial object.
 */
abstract class Record implements Stringable
{
    use StringableRecord;

    /**
     * The daily speed of the celestial object at the 
     * time to which the record refers expressed in
     * decimal degrees per day.
     * 
     * @var float
     */
    public protected(set) float $daily_speed;

    /**
     * Pack the object properties in an associative array.
     * 
     * @return array{daily_speed:string}
     */
    protected function packProperties(): array
    {
        return [
            "daily_speed" => "{$this->daily_speed}°/day"
        ];
    }

    /**
     * Get the parent properties packed in an associative 
     * array.
     * 
     * @return array
     */
    protected function getParentProperties(): array
    {
        return [];
    }
}