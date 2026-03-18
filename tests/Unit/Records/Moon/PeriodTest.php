<?php

namespace MarcoConsiglio\Ephemeris\Tests\Unit\Records\Moon;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Enums\Moon\Period as PeriodType;
use MarcoConsiglio\Ephemeris\Records\Moon\Period;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;

#[TestDox("The Moon Period")]
#[CoversClass(Period::class)]
#[UsesClass(PeriodType::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
class PeriodTest extends TestCase
{
    #[TestDox("has read-only properties \"start\" and '\"end\" which are SwissEphemerisDateTime.")]
    public function test_getters(): void
    {
        // Arrange
        [$start, $end] = $this->getRandomMoonPeriodInterval();
        $moon_period = new Period($start, $end, PeriodType::Waxing);

        // Act & Assert
        $this->assertProperty("start", $start, SwissEphemerisDateTime::class, $moon_period->start);
        $this->assertProperty("end", $end, SwissEphemerisDateTime::class, $moon_period->end);
    }

    #[TestDox("can be a waxing one.")]
    public function test_is_waxing(): void
    {
        // Arrange
        [$start, $end] = $this->getRandomMoonPeriodInterval();
        $moon_period = new Period($start, $end, PeriodType::Waxing);
        $failure_message = "This moon period should be a waxing one but found the opposite.";

        // Act & Assert
        $this->assertTrue($moon_period->isWaxing(), $failure_message);
        $this->assertFalse($moon_period->isWaning(), $failure_message);
    }

    #[TestDox("can be a waning one.")]
    public function test_is_waning(): void
    {
        // Arrange
        [$start, $end] = $this->getRandomMoonPeriodInterval();
        $moon_period = new Period($start, $end, PeriodType::Waning);
        $failure_message = "This moon period should be a waning one but found the opposite.";

        // Act & Assert
        $this->assertTrue($moon_period->isWaning(), $failure_message);
        $this->assertFalse($moon_period->isWaxing(), $failure_message);
    }

    #[TestDox("can be casted to string.")]
    public function test_casting_to_string(): void
    {
        // Arrange
        [$start, $end] = $this->getRandomMoonPeriodInterval();
        $type = $this->faker->randomElement(PeriodType::cases());
        $record = new Period($start, $end, $type);
        $start = $start->toDateTimeString();
        $end = $end->toDateTimeString();
        $type = ((array) $type)["name"]; // Cast PeriodType to string.

        // Act & Assert
        $this->assertEquals(<<<TEXT
Period
end: {$end}
start: {$start}
type: {$type}

TEXT,
            (string) $record    
        );
    }

    /**
     * Get a random Moon Period interval start and end.
     *
     * @return array {
     *      0: SwissEphemerisDateTime,
     *      1: SwissEphemerisDateTime
     * }
     */
    protected function getRandomMoonPeriodInterval(): array
    {
        $start = $this->getRandomSwissEphemerisDateTime();
        $end = $start->clone()->addWeeks(2);
        return [$start, $end];
    }
}
