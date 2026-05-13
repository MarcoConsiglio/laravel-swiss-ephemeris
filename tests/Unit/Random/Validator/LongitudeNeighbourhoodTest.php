<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Random\Validator;

use MarcoConsiglio\Ephemeris\Tests\Random\Validator\LongitudeNeighbourhood;
use MarcoConsiglio\Ephemeris\Tests\Unit\Random\Validator\TestCase as ValidatorTestCase;
use MarcoConsiglio\Goniometry\Angle;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(LongitudeNeighbourhood::class)]
class LongitudeNeighbourhoodTest extends ValidatorTestCase
{
    public function test_validate(): void
    {
        /**
         * Center value 0°
         */
        $this->testNeighbourhoodValidator(
            Angle::createFromValues(0),
            Angle::createFromValues(2),
            1, 359
        );
    }

    #[Override]
    protected function getValidatorClass(): string
    {
        return LongitudeNeighbourhood::class;
    }
}