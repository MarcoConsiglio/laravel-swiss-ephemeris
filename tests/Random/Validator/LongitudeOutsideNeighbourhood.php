<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Validator;

use MarcoConsiglio\Ephemeris\Tests\Random\Validator\LongitudeNeighbourhood as LongitudeNeighbourhoodValidator;
use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Interfaces\Angle as InterfacesAngle;
use Override;

class LongitudeOutsideNeighbourhood extends LongitudeNeighbourhoodValidator
{
    #[Override]
    protected function setMin(float &$value): void
    {
        $lower_extreme = $this->lower_extreme->toFloat();
        if ($lower_extreme == 0)
            $value = NextFloat::before(360);
        else
            $value = NextFloat::before($lower_extreme);
    }

    #[Override]
    protected function setMax(float &$value): void
    {
        $higher_extreme = $this->higher_extreme->toFloat();
        if ($higher_extreme == 360)
            $value = NextFloat::afterZero();
        else
            $value = NextFloat::after($this->higher_extreme->toFloat());
    }

    #[Override]
    protected function needToSwap(InterfacesAngle $alfa, InterfacesAngle $beta): bool
    {
        return false;
    }
}