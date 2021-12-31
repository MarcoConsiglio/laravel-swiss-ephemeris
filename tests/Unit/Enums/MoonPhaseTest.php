<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Enums;

use MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType as MoonPhase;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPeriod;
use MarcoConsiglio\Ephemeris\Tests\TestCase;

/**
 * @testdox The MoonPhase enumeration
 */
class MoonPhaseTest extends TestCase
{
    /**
     * @testdox consists of NewMoon, FirstQuarter, FullMoon, ThirdQuarter.
     */ 
    public function test_has_types()
    {
        // Arrange
        $enum_values = MoonPhase::cases();

        // Act
        $new_moon = MoonPhase::NewMoon;
        $first_quarter = MoonPhase::FirstQuarter;
        $full_moon = MoonPhase::FullMoon;
        $third_quarter = MoonPhase::ThirdQuarter;

        // Assert
        $failure_message = function (string $constant) {
            return "The $constant enumeration value is not working.";
        };
        $this->assertEquals($enum_values[0]->name, $new_moon->name, $failure_message("new moon"));
        $this->assertEquals($enum_values[1]->name, $first_quarter->name, $failure_message("first quarter"));
        $this->assertEquals($enum_values[2]->name, $full_moon->name, $failure_message("full moon"));
        $this->assertEquals($enum_values[3]->name, $third_quarter->name, $failure_message("third quarter"));
    }
}