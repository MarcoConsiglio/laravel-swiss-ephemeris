<?php

namespace MarcoConsiglio\Ephemeris\Tests\Unit\Enums;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Enums\PlanetsList;
use PHPUnit\Framework\Attributes\CoversClass;

#[TestDox("The PlanetsList enumeration")]
#[CoversClass(PlanetsList::class)]
class PlanetsListTest extends TestCase
{
    #[TestDox("consists of several common planets and objects collections.")]
    public function test_planets_list(): void
    {
        // Arrange
        $cases = [
            ["d",   PlanetsList::Default],
            ["p",   PlanetsList::DefaultPlusMainAsteroids],
            ["h",   PlanetsList::FictiousPlanets]
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
