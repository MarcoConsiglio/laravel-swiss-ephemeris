<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Validator;

use MarcoConsiglio\Ephemeris\Tests\Random\SwissEphemerisDateRange;
use MarcoConsiglio\FakerPhpNumberHelpers\Validation\Integer\Validator as IntegerValidator;

class SwissEphemerisDate extends IntegerValidator
{
    public function validate(int &$min, int &$max): void
    {
        $this->avoidExceedingValues($min, $max);
        $this->swap($min, $max);
    }

    protected function avoidExceedingValues(int &$min, int &$max): void
    {
        $this->avoidTooHighValues($min, $max);
        $this->avoidTooLowValues($min, $max);
    }

    protected function avoidTooHighValues(int &$min, int &$max): void
    {
        if ($this->greaterThan($min, SwissEphemerisDateRange::MAX))
            $this->setMin($min);
        if ($this->greaterThan($max, SwissEphemerisDateRange::MAX))
            $this->setMax($max);
    }

    protected function avoidTooLowValues(int &$min, int &$max): void
    {
        if ($this->lessThan($min, SwissEphemerisDateRange::MIN))
            $this->setMin($min);
        if ($this->lessThan($max, SwissEphemerisDateRange::MIN))
            $this->setMax($max);
    }

    protected function setMin(int &$value): void
    {
        $value = SwissEphemerisDateRange::MIN;
    }

    protected function setMax(int &$value): void
    {
        $value = SwissEphemerisDateRange::MAX;
    }
}