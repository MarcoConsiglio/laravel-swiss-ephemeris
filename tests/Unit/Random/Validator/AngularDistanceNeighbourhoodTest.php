<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Random\Validator;

use MarcoConsiglio\Ephemeris\Tests\Random\Validator\AngularDistanceNeighbourhood;
use MarcoConsiglio\Ephemeris\Tests\Unit\Random\Validator\TestCase as ValidatorTestCase;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The AngularDistanceNeighbourhood validator")]
#[CoversClass(AngularDistanceNeighbourhood::class)]
class AngularDistanceNeighbourhoodTest extends ValidatorTestCase
{
    #[TestDox("validates a AngularDistanceRange making it inside a delta error angle.")]
    public function test_validate(): void
    {
        /**
         * Center value: 0°
         */
        $this->testNeighbourhoodValidator(
            AngularDistance::createFromValues(0),
            Angle::createFromValues(2),
            -1, +1
        );

        /**
         * Center value: -180°
         */
        $this->testNeighbourhoodValidator(
            AngularDistance::createFromDecimal(-180),
            Angle::createFromValues(2),
            -179, +179
        );

        /**
         * Center value: +180°
         */
        $this->testNeighbourhoodValidator(
            AngularDistance::createFromDecimal(+180),
            Angle::createFromValues(2),
            -179, +179
        );
    }

    #[Override]
    protected function getValidatorClass(): string
    {
        return AngularDistanceNeighbourhood::class;
    }
}