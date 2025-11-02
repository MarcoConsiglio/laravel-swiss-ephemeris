<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Traits;

use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\ExpectationFailedException;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithCustomAssertions;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;

#[TestDox("With custom assertions")]
#[CoversTrait(WithCustomAssertions::class)]
class WithCustomAssertionsTest extends TestCase
{
    use WithCustomAssertions;

    #[TestDox("you can assert a date is what you expect.")]
    public function test_assert_date()
    {
        // Arrange
        $year = 2000; $month = 1; $day = 1; $hour = 0; $minute = 0; $second = 0;
        $actual_date = SwissEphemerisDateTime::create($year, $month, $day, $hour, $minute, $second);
        $expected_date = clone $actual_date;

        // Act & Assert
        $this->assertDate($actual_date, $expected_date);
    }

    #[TestDox("you can throw ExpectationFailedException if the date is not what you expect.")]
    public function test_assert_date_exception()
    {
        // Arrange
        $year = 2000; $month = 1; $day = 1; $hour = 0; $minute = 0; $second = 0;
        $actual_date = SwissEphemerisDateTime::create($year, $month, $day, $hour, $minute, $second);
        $expected_date = SwissEphemerisDateTime::create(2001, $month, $day, $hour, $minute, $second);  

        // Assert
        $this->expectException(ExpectationFailedException::class);

        // Act
        /**
         * Here, $date correspond to year 2000, while asserting is the year 2001.
         */
        $this->assertDate($actual_date, $expected_date);
    }
}