<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Generator;

use MarcoConsiglio\Ephemeris\Tests\Random\Generator\AngularDistance as AngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Angle;

class AngularDistanceNeighbourhood extends AngularDistanceGenerator
{
    public function generate(int $precision = PHP_FLOAT_DIG): Angle
    {
        return parent::generate($precision);
    }
}