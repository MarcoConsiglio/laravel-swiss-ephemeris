<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;

class AngularDistanceRange extends SexadecimalRange
{
    public static function min(): float
    {
        return NextFloat::after(-180.0);
    }

    public static function max(): float
    {
        return NextFloat::before(180.0);
    }
}