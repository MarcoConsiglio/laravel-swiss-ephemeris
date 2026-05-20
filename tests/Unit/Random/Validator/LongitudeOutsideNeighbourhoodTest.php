<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Random\Validator;

use MarcoConsiglio\Ephemeris\Tests\Random\Validator\LongitudeOutsideNeighbourhood;
use MarcoConsiglio\Ephemeris\Tests\Unit\Random\Validator\TestCase as ValidatorTestCase;
use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use MarcoConsiglio\Goniometry\Angle;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(LongitudeOutsideNeighbourhood::class)]
class LongitudeOutsideNeighbourhoodTest extends ValidatorTestCase
{
    public function test_validate(): void
    {
        $epsilon = Angle::createFromValues(30);
        $delta = $epsilon->sum($epsilon);

        /**
         * Center value:  180°
         */
        $this->testNeighbourhoodValidator(
            Angle::createFromValues(180),
            $delta,
            NextFloat::before(150),
            NextFloat::after(210)
        );
        
        /**
         * Center value: 30°
         */
        $this->testNeighbourhoodValidator(
            Angle::createFromValues(30),
            $delta,
            NextFloat::before(360),
            NextFloat::after(60)
        );

        /**
         * Center value: 0°
         */
        $this->testNeighbourhoodValidator(
            Angle::createFromValues(0),
            $delta,
            NextFloat::before(330),
            NextFloat::after(30)
        );

        /**
         * Center value: 330°
         */
        $this->testNeighbourhoodValidator(
            Angle::createFromValues(330),
            $delta,
            NextFloat::before(300),
            NextFloat::afterZero()
        );
    }

    #[Override]
    protected function getValidatorClass(): string
    {
        return LongitudeOutsideNeighbourhood::class;
    }   
}