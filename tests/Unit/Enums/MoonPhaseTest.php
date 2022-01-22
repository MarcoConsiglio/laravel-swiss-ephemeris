<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Enums;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\FullMoon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\FirstQuarter;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\NewMoon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\ThirdQuarter;
use MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType as MoonPhase;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;

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

    /**
     * @testdox can be casted to string with a trick.
     */
    public function test_cast_to_string()
    {
        // Arrange
        $moon_phase = $this->faker->randomElement(MoonPhase::cases());

        // Act
        $string = ((array) $moon_phase)["name"];

        // Assert
        $this->assertIsString($string, "I say it should be a string.");
    }

    /**
     * @testdox maps the new moon type to the NewMoon BuilderStrategy.
     */
    public function test_new_moon_strategy_correspond_to_new_moon_type()
    {
        // Arrange
        $strategy = NewMoon::class;

        // Act 
        $moon_phase = MoonPhase::getCorrespondingType($strategy);

        // Assert
        $this->assertEquals(MoonPhase::NewMoon, $moon_phase, "The NewMoon BuilderStrategy corresponds to MoonPhase::NewMoon.");
    }

    /**
     * @testdox maps the first quarter type to the FirstQuarter BuilderStrategy.
     */
    public function test_new_moon_strategy_correspond_to_first_quarter_type()
    {
        // Arrange
        $strategy = FirstQuarter::class;

        // Act 
        $moon_phase = MoonPhase::getCorrespondingType($strategy);

        // Assert
        $this->assertEquals(MoonPhase::FirstQuarter, $moon_phase, "The NewMoon BuilderStrategy corresponds to MoonPhase::NewMoon.");
    }

    /**
     * @testdox maps the full moon type to the FullMoon BuilderStrategy.
     */
    public function test_new_moon_strategy_correspond_to_full_moon_type()
    {
        // Arrange
        $strategy = FullMoon::class;

        // Act 
        $moon_phase = MoonPhase::getCorrespondingType($strategy);

        // Assert
        $this->assertEquals(MoonPhase::FullMoon, $moon_phase, "The NewMoon BuilderStrategy corresponds to MoonPhase::NewMoon.");
    }

    /**
     * @testdox maps the third quarter type to the ThirdQuarter BuilderStrategy.
     */
    public function test_new_moon_strategy_correspond_to_third_quarter_type()
    {
        // Arrange
        $strategy = ThirdQuarter::class;

        // Act 
        $moon_phase = MoonPhase::getCorrespondingType($strategy);

        // Assert
        $this->assertEquals(MoonPhase::ThirdQuarter, $moon_phase, "The NewMoon BuilderStrategy corresponds to MoonPhase::NewMoon.");
    }

    /**
     * @testdox can't map unregistered MoonPhaseStrategy.
     */
    public function test_cant_map_unknown_moon_phase_type()
    {
        // Arrange
        $fake_strategy = Angle::class;

        // Act
        $moon_phase = MoonPhase::getCorrespondingType($fake_strategy);

        // Assert
        $this->assertNull($moon_phase, "If the strategy is not registered within the getCorrespondinType method, it must return null.");
    }
}