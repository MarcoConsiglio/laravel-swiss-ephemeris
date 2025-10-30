<?php

namespace MarcoConsiglio\Ephemeris\Tests\Unit\Records\Moon;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Enums\Moon\Period as PeriodType;
use MarcoConsiglio\Ephemeris\Records\Moon\Period;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;

#[TestDox("The Moon\Period")]
#[CoversClass(Period::class)]
#[UsesClass(PeriodType::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
class PeriodTest extends TestCase
{
    #[TestDox("has read-only properties \"start\" and '\"end\" which are SwissEphemerisDateTime.")]
    public function test_getters()
    {
        // Arrange
        $start = SwissEphemerisDateTime::create("2021-06-10 13:00:00");
        $end = SwissEphemerisDateTime::create("2021-06-24 21:00:00");
        $moon_period = new Period($start, $end, PeriodType::Waxing);

        // Act
        $actual_start = $moon_period->start;
        $actual_end = $moon_period->end;

        // Assert
        $this->assertProperty("start", $start, SwissEphemerisDateTime::class, $actual_start);
        $this->assertProperty("end", $end, SwissEphemerisDateTime::class, $actual_end);
    }

    #[TestDox("can be a waxing one.")]
    public function test_is_waxing()
    {
        // Arrange
        // That's a waxing moon period.
        $start = SwissEphemerisDateTime::create("2021-06-10 13:00:00");
        $end = SwissEphemerisDateTime::create("2021-06-24 21:00:00");
        $moon_period = new Period($start, $end, PeriodType::Waxing);

        // Act & Assert
        $this->assertTrue($moon_period->isWaxing(), "The testing moon period should be a waxing one but found the opposite.");
        $this->assertFalse($moon_period->isWaning(), "The testing moon period should not be a waning one but found the opposite.");
    }

    #[TestDox("can be a waning one.")]
    public function test_is_waning()
    {
        // Arrange
        // That's a waning moon period.
        $start = SwissEphemerisDateTime::create("2021-06-24 22:00:00");
        $end = SwissEphemerisDateTime::create("2021-07-10 03:00:00");
        $moon_period = new Period($start, $end, PeriodType::Waning);

        // Act & Assert
        $this->assertTrue($moon_period->isWaning(), "The testing moon period should be a waning one but found the opposite.");
        $this->assertFalse($moon_period->isWaxing(), "The testing moon period should not be a waxing one but found the opposite.");
    }
}
