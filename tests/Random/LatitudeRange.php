<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;

class LatitudeRange extends SexadecimalRange
{
    public static function max(): float
    {
        return NextFloat::before(90.0);
    }

    public static function min(): float
    {
        return NextFloat::after(-90.0);
    }   
}