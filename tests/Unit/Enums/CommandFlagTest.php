<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Enums;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Enums\CommandFlag;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithFailureMessage;
use PHPUnit\Framework\Attributes\CoversNothing;

#[TestDox("The CommandFlag enumeration")]
#[CoversNothing]
class CommandFlagTest extends TestCase
{
    use WithFailureMessage;

    #[TestDox("has a flag to obtain ephemeris data for specific objects.")]
    public function test_object_selection_flag()
    {
        // Arrange & Act
        $constant_value = CommandFlag::ObjectSelection->value;
        $constant_name = CommandFlag::ObjectSelection->name;

        // Assert
        $this->assertEquals("p", $constant_value, $this->enumFail($constant_name));
        $this->assertIsString($constant_value, "The enumeration $constant_name must be a string.");
    }

    #[TestDox("has a flag to obtain differential ephemeris data for specific objects.")]
    public function test_differential_object_selection_flag()
    {
        // Arrange & Act
        $constant_value = CommandFlag::DifferentialObjectSelection->value;
        $constant_name = CommandFlag::DifferentialObjectSelection->name;

        // Assert
        $this->assertEquals("d", $constant_value, $this->enumFail($constant_name));
        $this->assertIsString($constant_value, "The enumeration $constant_name must be a string.");
    }

    #[TestDox("has a flag to obtain differential ephemeris data for specific objects from a heliocentric point of view.")]
    public function test_differential_heliocentric_object_selection_flag()
    {
        // Arrange & Act
        $constant_value = CommandFlag::DifferentialHeliocentricalObjectSelection->value;
        $constant_name = CommandFlag::DifferentialHeliocentricalObjectSelection->name;

        // Assert
        $this->assertEquals("dh", $constant_value, $this->enumFail($constant_name));
        $this->assertIsString($constant_value, "The enumeration $constant_name must be a string.");
    }

    #[TestDox("has a flag to set the start date of the query.")]
    public function test_begin_date_flag()
    {
        // Arrange & Act
        $constant_value = CommandFlag::BeginDate->value;
        $constant_name = CommandFlag::BeginDate->name;

        // Assert
        $this->assertEquals("b", $constant_value, $this->enumFail($constant_name));
        $this->assertIsString($constant_value, "The enumeration $constant_name must be a string.");
    }

    #[TestDox("has a flag to set the start terrestrial time of the query.")]
    public function test_terrestrial_time_flag()
    {
        // Arrange & Act
        $constant_value = CommandFlag::InputTerrestrialTime->value;
        $constant_name = CommandFlag::InputTerrestrialTime->name;

        // Assert
        $this->assertEquals("t", $constant_value, $this->enumFail($constant_name));
        $this->assertIsString($constant_value, "The enumeration $constant_name must be a string.");
    }

    #[TestDox("has a flag to set the start universal time of the query.")]
    public function test_universal_time_flag()
    {
        // Arrange & Act
        $constant_value = CommandFlag::InputUniversalTime->value;
        $constant_name = CommandFlag::InputUniversalTime->name;

        // Assert
        $this->assertEquals("ut", $constant_value, $this->enumFail($constant_name));
        $this->assertIsString($constant_value, "The enumeration $constant_name must be a string.");
    }

    #[TestDox("has a flag to set the start coordinated universal time of the query.")]
    public function test_universal_coordinated_time_flag()
    {
        // Arrange & Act
        $constant_value = CommandFlag::InputUniversalTimeCoordinated->value;
        $constant_name = CommandFlag::InputUniversalTimeCoordinated->name;

        // Assert
        $this->assertEquals("utc", $constant_value, $this->enumFail($constant_name));
        $this->assertIsString($constant_value, "The enumeration $constant_name must be a string.");
    }

    #[TestDox("has a flag to specify how many records will be extracted from the ephemeris.")]
    public function test_steps_number_flag()
    {
        // Arrange & Act
        $constant_value = CommandFlag::StepsNumber->value;
        $constant_name = CommandFlag::StepsNumber->name;

        // Assert
        $this->assertEquals("n", $constant_value, $this->enumFail($constant_name));
        $this->assertIsString($constant_value, "The enumeration $constant_name must be a string.");
    }

    #[TestDox("has a flag to specify how much time passes between records extracted from the ephemeris.")]
    public function test_time_steps_flag()
    {
        // Arrange & Act
        $constant_value = CommandFlag::TimeSteps->value;
        $constant_name = CommandFlag::TimeSteps->name;

        // Assert
        $this->assertEquals("s", $constant_value, $this->enumFail($constant_name));
        $this->assertIsString($constant_value, "The enumeration $constant_name must be a string.");
    }

    #[TestDox("has a flag to specify what data will be present in the ephemeris response.")]
    public function test_response_format_flag()
    {
        // Arrange & Act
        $constant_value = CommandFlag::ResponseFormat->value;
        $constant_name = CommandFlag::ResponseFormat->name;

        // Assert
        $this->assertEquals("f", $constant_value, $this->enumFail($constant_name));
        $this->assertIsString($constant_value, "The enumeration $constant_name must be a string.");
    }
}
