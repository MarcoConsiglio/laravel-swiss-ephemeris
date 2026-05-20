<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Random;

use MarcoConsiglio\Ephemeris\Tests\Random\SwissEphemerisDateRange;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[TestDox("The SwissEphemerisDateRange")]
#[CoversClass(SwissEphemerisDateRange::class)]
class SwissEphemerisDateRangeTest extends TestCase
{
    #[TestDox("express a years range.")]
    public function test_extremes(): void
    {
        // Arrange
        $range = new SwissEphemerisDateRange();

        // Act & Assert
        $this->assertEquals(SwissEphemerisDateRange::MIN, $range->start);
        $this->assertEquals(SwissEphemerisDateRange::MAX, $range->end);
    }
}