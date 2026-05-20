<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Generator;

use Faker\Generator;
use MarcoConsiglio\Ephemeris\Tests\Random\Generator\LongitudeNeighbourhood as LongitudeNeighbourhoodGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\LongitudeRange;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\LongitudeOutsideNeighbourhood as LongitudeOutsideNeighbourhoodValidator;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use Override;

class LongitudeOutsideNeighbourhood extends LongitudeNeighbourhoodGenerator
{
    public function __construct(
        Generator $generator, 
        LongitudeOutsideNeighbourhoodValidator $validator, 
        LongitudeRange $range
    ) {
        parent::__construct($generator, $validator, $range);
    }

    #[Override]
    public function generate(int $precision = PHP_FLOAT_DIG): Angle
    {
        $this->validate();
        if ($this->range->start <= $this->range->end) {
            if ($this->generator->boolean())
                $this->range = new LongitudeRange(0, $this->range->start);
            else
                $this->range = new LongitudeRange($this->range->end, 360);
            $this->validator = new PositiveSexadecimalValidator;
        } else {
            $this->range = new LongitudeRange($this->range->end, $this->range->start);
            $this->validator = new PositiveSexadecimalValidator;
        }
        return parent::generate($precision);
    }
}