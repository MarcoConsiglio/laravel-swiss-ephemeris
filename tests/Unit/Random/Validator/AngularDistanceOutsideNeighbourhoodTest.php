<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Random\Validator;

use MarcoConsiglio\Ephemeris\Tests\Random\Validator\AngularDistanceOutsideNeighbourhood;
use MarcoConsiglio\Ephemeris\Tests\Unit\Random\Validator\TestCase as ValidatorTestCase;
use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(AngularDistanceOutsideNeighbourhood::class)]
class AngularDistanceOutsideNeighbourhoodTest extends ValidatorTestCase
{
    public function test_validate(): void
    {
        /**
         * Center value 0°
         */
        $this->testNeighbourhoodValidator(
            Angle::createFromValues(0),
            Angle::createFromValues(2),
            NextFloat::before(-1),
            NextFloat::after(+1)
        );

        /**
         * Center value +180°
         */
        $this->testNeighbourhoodValidator(
            AngularDistance::createFromValues(+180),
            Angle::createFromValues(2),
            NextFloat::before(+179),
            NextFloat::after(-179)
        );
        
        /**
         * Center value -180°
         */
        $this->testNeighbourhoodValidator(
            AngularDistance::createFromValues(-180),
            Angle::createFromValues(2),
            NextFloat::before(+179),
            NextFloat::after(-179)
        );
    }

    #[Override]
    protected function getValidatorClass(): string
    {
        return AngularDistanceOutsideNeighbourhood::class;
    }
}