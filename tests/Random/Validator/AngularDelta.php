<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Validator;

use MarcoConsiglio\Ephemeris\Tests\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;

abstract class AngularDelta extends SexadecimalValidator
{    
    protected Angle $epsilon;

    protected Angle $higher_extreme;

    protected Angle $lower_extreme;

    public function __construct(
        protected Angle $center_value, 
        protected Angle $delta
    ) {
        if ($this->delta->isClockwise()) 
            $this->delta = $this->delta->toggleDirection();
        $this->calcDeltaExtremes();
    }

    public function validate(float &$min, float &$max): void
    {
        $this->setMin($min);
        $this->setMax($max);
    }

    abstract protected function setMin(float &$value): void;

    abstract protected function setMax(float &$value): void;

    protected function calcEpsilon(): void
    {
        $epsilon_value = $this->delta->toSexadecimalDegrees()->value->div(2);
        $this->epsilon = Angle::createFromDecimal($epsilon_value->toFloat());
    }

    abstract protected function calcHigherExtreme(): void;

    abstract protected function calcLowerExtreme(): void;

    protected function calcDeltaExtremes(): void
    {
        $this->calcEpsilon();
        $this->calcHigherExtreme();
        $this->calcLowerExtreme();
    }
}