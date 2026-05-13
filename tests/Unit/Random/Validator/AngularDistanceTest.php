<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Random\Validator;

use MarcoConsiglio\Ephemeris\Tests\Random\AngularDistanceRange;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\AngularDistance;
use MarcoConsiglio\Ephemeris\Tests\Unit\Random\Validator\TestCase as ValidatorTestCase;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The AngularDistance validator")]
#[CoversClass(AngularDistance::class)]
#[UsesClass(AngularDistanceRange::class)]
class AngularDistanceTest extends ValidatorTestCase
{
    #[TestDox("validates a AngularDistanceRange.")]
    public function test_validate(): void
    {
        /**
         * $min = INF
         * $max = INF
         */
        $this->testValidator(
            INF, INF,
            AngularDistanceRange::min(),
            AngularDistanceRange::max()
        );

        /**
         * $min > +180
         * $max > +180
         */
        $this->testValidator(
            181, 181,
            AngularDistanceRange::min(),
            AngularDistanceRange::max()
        );

        /**
         * $min < -180 
         * $max < -180
         */
        $this->testValidator(
            -181, -181,
            AngularDistanceRange::min(),
            AngularDistanceRange::max()
        );

        /**
         * $min < -180
         * $max > +180
         */
        $this->testValidator(
            -181, +181,
            AngularDistanceRange::min(),
            AngularDistanceRange::max()
        );

        /**
         * $min > +180
         * $max < -180
         */
        $this->testValidator(
            +181, -181,
            AngularDistanceRange::min(),
            AngularDistanceRange::max()
        );
    }

    #[Override]
    protected function getValidatorClass(): string
    {
        return AngularDistance::class;
    }
}