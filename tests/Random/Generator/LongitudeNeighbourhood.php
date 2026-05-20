<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Generator;

use Faker\Generator;
use MarcoConsiglio\Ephemeris\Tests\Random\Generator\Longitude as LongitudeGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\LongitudeRange;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\LongitudeNeighbourhood as LongitudeNeighbourhoodValidator;

class LongitudeNeighbourhood extends LongitudeGenerator
{
    public function __construct(
        Generator $generator, 
        LongitudeNeighbourhoodValidator $validator, 
        LongitudeRange $range
    ) {
        parent::__construct($generator, $validator, $range);
    }
}