<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random;

use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Random\SexadecimalRange;
use Override;

class LatitudeRange extends SexadecimalRange
{
    public const float MAX = 90.0;

    public const float MIN = -self::MAX;

    #[Override]
    public static function max(): float
    {
        return self::MAX;
    }

    #[Override]
    public static function min(): float
    {
        return self::MIN;
    }
}