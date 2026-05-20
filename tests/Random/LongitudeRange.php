<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random;

use MarcoConsiglio\Goniometry\Random\SexadecimalRange;

class LongitudeRange extends SexadecimalRange
{
    public static function min(): float
    {
        return 0.0;
    }    
}