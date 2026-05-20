<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Random\Validator;

use MarcoConsiglio\Ephemeris\Tests\Random\LatitudeRange;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\Latitude;
use MarcoConsiglio\Ephemeris\Tests\Unit\Random\Validator\TestCase as ValidatorTestCase;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The Latitude validator")]
#[CoversClass(Latitude::class)]
class LatitudeTest extends ValidatorTestCase
{
    #[TestDox("validates a LatitudeRange.")]
    public function test_validate(): void
    {
        /**
         * $min = INF
         * $max = INF
         */
        $this->testValidator(
            INF, INF,
            LatitudeRange::MIN,
            LatitudeRange::MAX
        );

        /**
         * $min > +90
         * $max > +90
         */
        $this->testValidator(
            +91, +91,
            LatitudeRange::MIN,
            LatitudeRange::MAX
        );

        /**
         * $min < -90
         * $max < -90
         */
        $this->testValidator(
            -91, -91,
            LatitudeRange::MIN,
            LatitudeRange::MAX
        );

        /**
         * $min < -90
         * $max > +90
         */
        $this->testValidator(
            -91, +91,
            LatitudeRange::MIN,
            LatitudeRange::MAX
        );     
        
        /**
         * $min > +90
         * $max < -90
         */
        $this->testValidator(
            +91, -91,
            LatitudeRange::MIN,
            LatitudeRange::MAX
        );
    }

    #[Override]
    protected function getValidatorClass(): string
    {
        return Latitude::class;
    }
}