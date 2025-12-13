<?php
namespace MarcoConsiglio\Ephemeris\Records;

use MarcoConsiglio\Ephemeris\Traits\StringableRecord;
use Stringable;

/**
 * It defines the abstract concept of a record of the 
 * ephemeris.
 */
abstract class Record implements Stringable
{
    use StringableRecord;

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