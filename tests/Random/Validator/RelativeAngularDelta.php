<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Validator;

use MarcoConsiglio\Ephemeris\Tests\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\AngularDelta as AngularDeltaValidator;

class RelativeAngularDelta extends AngularDeltaValidator
{
    protected function calcHigherExtreme(): void
    {
        $this->higher_extreme = $this->center_value->sum($this->epsilon);
    }

    protected function calcLowerExtreme(): void
    {
        $this->lower_extreme = $this->center_value->sum($this->epsilon->oppositeRotation());
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