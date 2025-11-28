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

        // Act & Assert
        $this->assertProperty("start", $start, SwissEphemerisDateTime::class, $moon_period->start);
        $this->assertProperty("end", $end, SwissEphemerisDateTime::class, $moon_period->end);
    }

    #[TestDox("can be a waxing one.")]
    public function test_is_waxing()
    {
        // Arrange
        $start = SwissEphemerisDateTime::create("2021-06-10 13:00:00");
        $end = SwissEphemerisDateTime::create("2021-06-24 21:00:00");
        $moon_period = new Period($start, $end, PeriodType::Waxing);
        $failure_message = "This moon period should be a waxing one but found the opposite.";

        // Act & Assert
        $this->assertTrue($moon_period->isWaxing(), $failure_message);
        $this->assertFalse($moon_period->isWaning(), $failure_message);
    }

    #[TestDox("can be a waning one.")]
    public function test_is_waning()
    {
        // Arrange
        $start = SwissEphemerisDateTime::create("2021-06-24 22:00:00");
        $end = SwissEphemerisDateTime::create("2021-07-10 03:00:00");
        $moon_period = new Period($start, $end, PeriodType::Waning);
        $failure_message = "This moon period should be a waning one but found the opposite.";

        // Act & Assert
        $this->assertTrue($moon_period->isWaning(), $failure_message);
        $this->assertFalse($moon_period->isWaxing(), $failure_message);
    }

    #[TestDox("can be casted to string.")]
    public function test_casting_to_string()
    {
        // Arrange
        $start = new SwissEphemerisDateTime($this->faker->dateTimeAD());
        $end = new SwissEphemerisDateTime($this->faker->dateTimeAD());
        $type = $this->faker->randomElement(PeriodType::cases());
        $record = new Period($start, $end, $type);
        $start = $start->toDateTimeString();
        $end = $end->toDateTimeString();
        $type = ((array) $type)["name"];

        // Act & Assert
        $this->assertEquals(<<<TEXT
Moon Period
start: {$start}
end: {$end}
type: {$type}
TEXT,
            (string) $record    
        );
    }
}
