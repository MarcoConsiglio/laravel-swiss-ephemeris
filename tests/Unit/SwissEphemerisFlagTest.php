<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Command\SwissEphemerisFlag;

#[CoversClass(SwissEphemerisFlag::class)]
#[TestDox("The SwissEphemerisFlag")]
class SwissEphemerisFlagTest extends TestCase
{
    #[TestDox("can cast the flag to string in the proper format acepted by the Swiss Ephemeris executable.")]
    public function test_cast_a_flag_to_string()
    {
        // Arrange
        $flag_name = $this->faker->randomLetter();
        $flag_values = [
            $this->faker->randomDigit(),
            $this->faker->randomDigit(),
            $this->faker->randomDigit()
        ];
        $flag = new SwissEphemerisFlag($flag_name, $flag_values);
        $expected_string = "-{$flag_name}{$flag_values[0]}{$flag_values[1]}{$flag_values[2]}";
        $class = SwissEphemerisFlag::class;

        // Act
        $actual_string = (string) $flag;

        // Assert
        $this->assertIsString($actual_string);
        $this->assertEquals($expected_string, $actual_string, 
            "The $class class do not cast flags properly for the Swiss Ephemeris executable.");
    }
}