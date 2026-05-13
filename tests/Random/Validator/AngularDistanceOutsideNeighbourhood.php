<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Validator;

use MarcoConsiglio\Ephemeris\Tests\Random\Validator\AngularDistanceNeighbourhood as AngularDistanceNeighbourhoodValidator;

class AngularDistanceOutsideNeighbourhood extends AngularDistanceNeighbourhoodValidator
{
    protected function setMin(float &$value): void
    {
        $value = $this->lower_extreme->toFloat();
    }

    protected function setMax(float &$value): void
    {
        $value = $this->higher_extreme->toFloat();
    }
}