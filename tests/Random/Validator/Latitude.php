<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Validator;

use MarcoConsiglio\Ephemeris\Tests\Random\LatitudeRange;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;

class Latitude extends SexadecimalValidator
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
        if ($this->greaterThan($min, LatitudeRange::MAX)) $this->setMin($min);
        if ($this->greaterThan($max, LatitudeRange::MAX)) $this->setMax($max);
    }

    protected function avoidTooLowValues(float &$min, float &$max): void
    {
        if ($this->lessThan($min, LatitudeRange::MIN)) $this->setMin($min);
        if ($this->lessThan($max, LatitudeRange::MIN)) $this->setMax($max);
    }

    protected function setMin(float &$value): void
    {
        $value = LatitudeRange::MIN;
    }

    protected function setMax(float &$value): void
    {
        $value = LatitudeRange::MAX;
    }
}