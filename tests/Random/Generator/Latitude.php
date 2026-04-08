<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Generator;

use Faker\Generator;
use MarcoConsiglio\Ephemeris\Tests\Random\LatitudeRange;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\Latitude as LatitudeValidator;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Random\Generator\Angle as AngleGenerator;

class Latitude extends AngleGenerator
{
    public function __construct(
        Generator $generator, 
        LatitudeValidator $validator, 
        LatitudeRange $range
    ) {
        return parent::__construct($generator, $validator, $range);
    }

    public function generate(int $precision = PHP_FLOAT_DIG): Angle
    {
        return parent::generate($precision);
    }
}