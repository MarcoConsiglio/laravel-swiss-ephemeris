<?php
namespace MarcoConsiglio\Ephemeris\Records;

use MarcoConsiglio\Goniometry\Angle;

class DailySpeed extends Angle
{
    public function __toString()
    {
        return "{$this}/day";
    }
}