<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Generator;

use Faker\Generator;
use MarcoConsiglio\Ephemeris\Tests\Random\LongitudeRange;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\Longitude as LongitudeValidator;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\LongitudeNeighbourhood as LongitudeNeighbourhoodValidator;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Random\Generator\PositiveAngle as PositiveAngleGenerator;

class Longitude extends PositiveAngleGenerator
{
    public function __construct(
        Generator $generator, 
        LongitudeValidator|LongitudeNeighbourhoodValidator $validator, 
        LongitudeRange $range)
    {
        return parent::__construct($generator, $validator, $range);
    }

    public function generate(int $precision = PHP_FLOAT_DIG): Angle
    {
        $this->validate();
        return parent::generate($precision);
    }
}