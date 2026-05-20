<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Validator;

use MarcoConsiglio\Ephemeris\Tests\Random\Validator\AngularDelta as AngularDeltaValidator;
class LongitudeNeighbourhood extends AngularDeltaValidator
{
    protected function calcLowerExtreme(): void
    {
        $this->lower_extreme = 
            $this->center_value->absSum($this->epsilon->oppositeRotation());
    }

    protected function calcHigherExtreme(): void
    {
        $this->higher_extreme = 
            $this->center_value->absSum($this->epsilon);
    }

    protected function setMin(float &$value): void
    {
        $value = $this->lower_extreme->toFloat();
    }

    protected function setMax(float &$value): void
    {
        $value = $this->higher_extreme->toFloat();
    }
}