<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Generator;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngle as RelativeAngleGenerator;

class AngularDistance extends RelativeAngleGenerator
{
    public function generate(int $precision = PHP_FLOAT_DIG): Angle
    {
        return parent::generate($precision);
    }
}