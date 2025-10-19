<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Enums;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\CoversClass;
use MarcoConsiglio\Ephemeris\Enums\TimeSteps;

#[TestDox("The TimeSteps enumeration")]
#[CoversClass(TimeSteps::class)]
class TimeStepsTest extends TestCase
{
    #[TestDox("has references to the time length of steps in ephemeris response.")]
    public function test_time_steps(): void
    {
        // Arrange
        $cases = [
            ["y", TimeSteps::YearSteps],
            ["mo", TimeSteps::MonthSteps],
            ["m", TimeSteps::MinuteSteps],
            ["s", TimeSteps::SecondSteps]
        ];
        $failure_message = function (string $constant) {
            return "The $constant enumeration value is not working.";
        };

        // Act & Assert
        foreach ($cases as $case) {
            $this->assertEquals($case[0], $case[1]->value, $failure_message($case[1]->name));
        }
    }
}
