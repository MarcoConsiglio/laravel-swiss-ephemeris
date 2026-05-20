<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Random\Validator;

use MarcoConsiglio\Ephemeris\Tests\Random\SwissEphemerisDateRange;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\SwissEphemerisDate;
use MarcoConsiglio\Ephemeris\Tests\Unit\Random\Validator\TestCase as ValidatorTestCase;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(SwissEphemerisDate::class)]
class SwissEphemerisDateTest extends ValidatorTestCase
{
    public function test_validate(): void
    {
        /**
         * $min < 1800
         * $max < 1800
         */
        $this->testValidator(
            1799, 1799,
            SwissEphemerisDateRange::MIN,
            SwissEphemerisDateRange::MAX
        );

        /**
         * $min > 2399
         * 1800 ≤ $max ≤ 2399
         */
        $this->testValidator(
            2400, 2000,
            SwissEphemerisDateRange::MIN,
            2000
        );

        /**
         * 1800 ≤ $min ≤ 2399
         * $max > 2399
         */
        $this->testValidator(
            2000, 2400,
            2000, SwissEphemerisDateRange::MAX
        );

        /**
         * $min < 1800
         * 1800 ≤ $max ≤ 2399
         */
        $this->testValidator(
            1799, 2000,
            SwissEphemerisDateRange::MIN,
            2000
        );

        /**
         * 1800 ≤ $min ≤ 2399
         * $max < 1800
         */
        $this->testValidator(
            2000, 1799,
            2000,
            SwissEphemerisDateRange::MAX
        );

        /**
         * $min > 2399
         * $max > 2399
         */
        $this->testValidator(
            2400, 2400,
            SwissEphemerisDateRange::MIN,
            SwissEphemerisDateRange::MAX            
        );
    }

    #[Override]
    protected function getValidatorClass(): string
    {
        return SwissEphemerisDate::class;
    }
}