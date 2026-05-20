<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Generator;

use Faker\Generator;
use MarcoConsiglio\Ephemeris\Tests\Random\LatitudeRange;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\Latitude as LatitudeValidator;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngle as RelativeAngleGenerator;

class Latitude extends RelativeAngleGenerator
{
    public function __construct(
        Generator $generator, 
        LatitudeValidator $validator, 
        LatitudeRange $range
    ) {
        parent::__construct($generator, $validator, $range);
    }
}