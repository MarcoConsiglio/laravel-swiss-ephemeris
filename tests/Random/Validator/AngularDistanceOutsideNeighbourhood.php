<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Validator;

use MarcoConsiglio\Ephemeris\Tests\Random\Validator\AngularDistanceNeighbourhood as AngularDistanceNeighbourhoodValidator;
use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use Override;

class AngularDistanceOutsideNeighbourhood extends AngularDistanceNeighbourhoodValidator
{
    #[Override]
    protected function setMin(float &$value): void
    {
        $value = NextFloat::before($this->lower_extreme->toFloat());
    }

    #[Override]
    protected function setMax(float &$value): void
    {
        $value = NextFloat::after($this->higher_extreme->toFloat());
    }
}