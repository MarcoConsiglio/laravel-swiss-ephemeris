<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Generator;

use Faker\Generator;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\AngularDistanceNeighbourhood as AngularDistanceNeighbourhoodValidator;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngularDistance as AngularDistanceGenerator;

class AngularDistanceNeighbourhood extends AngularDistanceGenerator
{
    public function __construct(
        Generator $generator, 
        AngularDistanceNeighbourhoodValidator $validator, 
        AngularDistanceRange $range
    ) {
        $this->generator = $generator;
        $this->validator = $validator;
        $this->range = $range;
    }

    public function generate(int $precision = PHP_FLOAT_DIG): AngularDistance
    {
        return parent::generate($precision);
    }
}