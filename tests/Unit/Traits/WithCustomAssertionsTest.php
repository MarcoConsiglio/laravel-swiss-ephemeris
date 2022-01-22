<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Traits;

use MarcoConsiglio\Ephemeris\SwissDateTime;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithCustomAssertions;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use Mockery\Expectation;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\ExpectationFailedException;

/**
 * @testdox With custom assertions
 */
class WithCustomAssertionsTest extends TestCase
{
    use WithCustomAssertions;

    /**
     * @testdox you can asser a date is what you expect.
     */
    public function test_assert_date()
    {
        // Arrange
        $year = 2000; $month = 1; $day = 1; $hour = 0; $minute = 0; $second = 0;
        $date = SwissDateTime::create($year, $month, $day, $hour, $minute, $second);
        SwissDateTime::setTestNow($date);

        // Act & Assert
        $this->assertDate($date, $year, $month, $day, $hour, $minute, $second);
    }

    public function test_assert_date_exception()
    {
        // Arrange
        $year = 2000; $month = 1; $day = 1; $hour = 0; $minute = 0; $second = 0;
        $date = SwissDateTime::create($year, $month, $day, $hour, $minute, $second);
        SwissDateTime::setTestNow($date);       

        // Assert
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage("Failed asserting that '".$date->toDateTimeString()."' equals '2001-01-01 00:00:00'.");

        // Act
        $this->assertDate($date, 2001, $month, $day, $hour, $minute, $second);
    }
}