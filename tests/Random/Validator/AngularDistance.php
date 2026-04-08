<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Validator;

use MarcoConsiglio\Ephemeris\Tests\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;

class AngularDistance extends SexadecimalValidator
{
    public function validate(float &$min, float &$max): void
    {
        $this->avoidInvalidFloats($min, $max);
        $this->avoidExceedingValues($min, $max);
        $this->swap($min, $max);
    }

    protected function avoidExceedingValues(float &$min, float &$max): void
    {
        $this->avoidTooHighValues($min, $max);
        $this->avoidTooLowValues($min, $max);
    }

    protected function avoidTooHighValues(float &$min, float &$max): void
    {
        if ($this->greaterThanOrEqual($min, AngularDistanceRange::max()))
            $this->setMin($min);
        if ($this->greaterThanOrEqual($max, AngularDistanceRange::max()))
            $this->setMax($max);
    }

    protected function avoidTooLowValues(float &$min, float &$max): void
    {
        if ($this->lessThanOrEqual($min, AngularDistanceRange::min()))
            $this->setMin($min);
        if ($this->lessThanOrEqual($max, AngularDistanceRange::min()))
            $this->setMax($max);
    }

    protected function setMin(float &$value): void
    {
        $value = AngularDistanceRange::min();
    }

    protected function setMax(float &$value): void
    {
        $value = AngularDistanceRange::max();
    }
}