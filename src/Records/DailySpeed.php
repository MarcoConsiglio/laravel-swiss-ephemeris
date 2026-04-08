<?php
namespace MarcoConsiglio\Ephemeris\Records;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromSexadecimal;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;

class DailySpeed extends Angle
{
    public function __toString()
    {
        return parent::__toString();
    }

    public static function createFromDecimal(float|SexadecimalDegrees $sexadecimal): DailySpeed
    {
        return new DailySpeed(new FromSexadecimal($sexadecimal));
    }
}