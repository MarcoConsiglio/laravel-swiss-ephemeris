<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Validator;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;
use MarcoConsiglio\Goniometry\Random\Validator\Sexadecimal as SexadecimalValidator;

abstract class AngularDelta extends SexadecimalValidator
{    
    protected Angle $epsilon;

    protected AngleInterface $higher_extreme;

    protected AngleInterface $lower_extreme;

    public function __construct(
        protected AngleInterface $center_value, 
        protected Angle $delta
    ) {
        $this->delta = $this->delta->absolute();
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
        $this->swapExtremes();
    }

    protected function swapExtremes(): void
    {
        if ($this->needToSwap($this->lower_extreme, $this->higher_extreme)) {
            $temp = $this->lower_extreme;
            $this->lower_extreme = $this->higher_extreme;
            $this->higher_extreme = $temp;
        }
    }

    protected function needToSwap(AngleInterface $alfa, AngleInterface $beta): bool
    {
        $alfa_value = $alfa->toSexadecimalDegrees()->value;
        $beta_value = $beta->toSexadecimalDegrees()->value;
        return $alfa_value->gt($beta_value);
    }
}