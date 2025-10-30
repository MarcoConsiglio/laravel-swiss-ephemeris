<?php

namespace MarcoConsiglio\Ephemeris\Tests\Unit\Enums;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use MarcoConsiglio\Ephemeris\Enums\SinglePlanet;

#[TestDox("The SinglePlanet enumeration")]
#[CoversClass(SinglePlanet::class)]
class SinglePlanetTest extends TestCase
{
    #[TestDox("consists of several reference to a single planet or object.")]   
    public function test_output_formats(): void
    {
        // Arrange
        $failure_message = function (string $constant) {
            return "The $constant enumeration value is not working.";
        };
        $enum_cases = [
            ["0", SinglePlanet::Sun],
            ["1", SinglePlanet::Moon],
            ["2", SinglePlanet::Mercury],
            ["3", SinglePlanet::Venus],
            ["4", SinglePlanet::Mars],
            ["5", SinglePlanet::Jupiter],
            ["6", SinglePlanet::Saturn],
            ["7", SinglePlanet::Uranus],
            ["9", SinglePlanet::Pluto],
            ["C", SinglePlanet::Earth],
            ["A", SinglePlanet::MeanLunarApogee],            
            ["A", SinglePlanet::Lilith],            
            ["A", SinglePlanet::BlackMoon],            
            ["B", SinglePlanet::OsculatingLunarApogee],            
            ["B", SinglePlanet::TrueLilith],             
            ["c", SinglePlanet::InterpolatedLunarApogee],             
            ["c", SinglePlanet::NaturalLunarApogee],             
            ["c", SinglePlanet::LunarApogee],             
            ["g", SinglePlanet::InterpolatedLunarPerigee],             
            ["g", SinglePlanet::NaturalLunarPerigee],             
            ["g", SinglePlanet::LunarPerigee],             
        ];

        // Act & Assert
        foreach ($enum_cases as $case) {
            $this->assertEquals($case[0], $case[1]->value, $failure_message($case[1]->name));
        }

    }
}
