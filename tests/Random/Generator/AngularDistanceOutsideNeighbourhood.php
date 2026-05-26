<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Generator;

use Faker\Generator;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\AngularDistanceOutsideNeighbourhood as AngularDistanceOutsideNeighbourhoodValidator;
use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Generator\RelativeAngularDistance as AngularDistanceGenerator;
use MarcoConsiglio\Goniometry\Random\Validator\NegativeSexadecimal as NegativeSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\PositiveSexadecimal as PositiveSexadecimalValidator;
use MarcoConsiglio\Goniometry\Random\Validator\RelativeSexadecimal as RelativeSexadecimalValidator;

class AngularDistanceOutsideNeighbourhood extends AngularDistanceGenerator
{
    public function __construct(
        Generator $generator, 
        AngularDistanceOutsideNeighbourhoodValidator $validator, 
        AngularDistanceRange $range
    ) {
        parent::__construct($generator, $validator, $range);
    }

    public function generate(int $precision = PHP_FLOAT_DIG): AngularDistance
    {
        $this->validate();
        if ($this->validator->areBothPositive($this->range->start, $this->range->end)) {
            if ($this->generator->boolean())
                $this->range = new AngularDistanceRange(0, $this->range->start);
            else
                $this->range = new AngularDistanceRange($this->range->end, AngularDistanceRange::max());
            $this->validator = new PositiveSexadecimalValidator;
            return parent::generate($precision);
        }
        if ($this->validator->areBothNegative($this->range->start, $this->range->end)) {
            if ($this->generator->boolean())
                $this->range = new AngularDistanceRange(AngularDistanceRange::min(), $this->range->start);
            else
                $this->range = new AngularDistanceRange($this->range->end, NextFloat::beforeZero());
            $this->validator = new NegativeSexadecimalValidator;
            return parent::generate($precision);
        }
        $this->validator = new RelativeSexadecimalValidator;
        if ($this->generator->boolean())
            $this->range = new AngularDistanceRange(
                0, $this->range->end
            );
        else
            $this->range = new AngularDistanceRange(
                $this->range->start,
                NextFloat::beforeZero()
            );
        return parent::generate($precision);
    }
}