<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Validator;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\AngularDelta as AngularDeltaValidator;

class AbsoluteAngularDelta extends AngularDeltaValidator
{
    protected function calcHigherExtreme(): void
    {
        $this->higher_extreme = Angle::absSum(
            $this->center_value, $this->epsilon
        );
    }

    protected function calcLowerExtreme(): void
    {
        $this->lower_extreme = Angle::absSum(
            $this->center_value, $this->epsilon->toggleDirection()
        );
    }
}