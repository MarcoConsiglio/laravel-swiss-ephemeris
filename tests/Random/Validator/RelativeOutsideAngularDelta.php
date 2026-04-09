<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Validator;

use MarcoConsiglio\Ephemeris\Tests\Random\AngularDistanceRange;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\RelativeAngularDelta as RelativeAngularDeltaValidator;
use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;

class RelativeOutsideAngularDelta extends RelativeAngularDeltaValidator
{
    protected function setMin(float &$value): void
    {
        $lower_extreme = $this->lower_extreme->toSexadecimalDegrees()->value;
        $min_angular_distance = AngularDistanceRange::min();
        if ($lower_extreme->lt($min_angular_distance))
            $value = AngularDistanceRange::min();
        else
            $value = NextFloat::before($this->lower_extreme->toFloat());
    }

    protected function setMax(float &$value): void
    {
        $higher_extreme = $this->higher_extreme->toSexadecimalDegrees()->value;
        $max_angular_distance = AngularDistanceRange::max();
        if ($higher_extreme->gt($max_angular_distance))
            $value = AngularDistanceRange::max();
        else
            $value = NextFloat::after($this->higher_extreme->toFloat());
    }
}