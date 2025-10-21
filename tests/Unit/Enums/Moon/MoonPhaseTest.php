<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Enums\Moon;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\FullMoon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\FirstQuarter;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\NewMoon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\ThirdQuarter;
use MarcoConsiglio\Ephemeris\Enums\Moon\Phase;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithFailureMessage;
use MarcoConsiglio\Ephemeris\Tests\Unit\Dummy\NonExistentMoonStrategy;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Goniometry\Angle;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Phase::class)]
#[TestDox("The PhaseType enumeration")]
class MoonPhaseTest extends TestCase
{
    use WithFailureMessage;

    #[DoesNotPerformAssertions]
    #[TestDox("has a new moon constant.")]
    public function test_new_moon_phase()
    {
        // Act
        $constant = Phase::NewMoon;
    }

    #[DoesNotPerformAssertions]
    #[TestDox("has a first quarter constant.")]
    public function test_first_quarter_phase()
    {
        // Act
        $constant = Phase::FirstQuarter;
    }

    #[DoesNotPerformAssertions]
    #[TestDox("has a third quarter constant.")]
    public function test_third_quarter_phase()
    {
        // Act
        $constant = Phase::ThirdQuarter;
    }

    #[DoesNotPerformAssertions]
    #[TestDox("has a full moon constant.")]
    public function test_full_moon_phase()
    {
        // Act
        $constant = Phase::FullMoon;
    }

    #[TestDox("maps the NewMoon strategy to the NewMoon constant.")]
    public function test_map_new_moon_strategy()
    {
        // Arrange
        $strategy = NewMoon::class;
        $constant_name = Phase::NewMoon->name;

        // Act 
        $moon_phase = Phase::getCorrespondingType($strategy);

        // Assert
        $this->assertEquals(Phase::NewMoon, $moon_phase, "The NewMoon BuilderStrategy must corresponds to {$constant_name}.");
    }

    #[TestDox("maps the FirstQuarter strategy to the FirstQuarter constant.")]
    public function test_map_first_quarter_strategy()
    {
        // Arrange
        $strategy = FirstQuarter::class;
        $constant_name = Phase::FirstQuarter->name;

        // Act 
        $moon_phase = Phase::getCorrespondingType($strategy);

        // Assert
        $this->assertEquals(Phase::FirstQuarter, $moon_phase, "The NewMoon BuilderStrategy must corresponds to {$constant_name}.");
    }

    #[TestDox("maps the FullMoon strategy to the FullMoon constant.")]
    public function test_map_full_moon_strategy()
    {
        // Arrange
        $strategy = FullMoon::class;
        $constant_name = Phase::FullMoon->name;

        // Act 
        $moon_phase = Phase::getCorrespondingType($strategy);

        // Assert
        $this->assertEquals(Phase::FullMoon, $moon_phase, "The NewMoon BuilderStrategy must corresponds to {$constant_name}.");
    }

    #[TestDox("maps the ThirdQuarter strategy to the ThirdQuarter constant.")]
    public function test_map_third_quarter_strategy()
    {
        // Arrange
        $strategy = ThirdQuarter::class;
        $constant_name = Phase::ThirdQuarter->name;

        // Act 
        $moon_phase = Phase::getCorrespondingType($strategy);

        // Assert
        $this->assertEquals(Phase::ThirdQuarter, $moon_phase, "The NewMoon BuilderStrategy must corresponds to {$constant_name}.");
    }

    #[TestDox("maps the NewMoon constant to the NewMoon strategy.")]
    public function test_map_new_moon_type()
    {
        // Arrange
        $moon_phase = Phase::NewMoon;
        $corresponding_strategy = NewMoon::class;

        // Act & Assert
        $this->assertEquals($corresponding_strategy, Phase::getCorrespondingStrategy($moon_phase));
    }

    #[TestDox("maps the FirstQuarter constant to the FirstQuarter strategy.")]
    public function test_map_first_quarter_type()
    {
        // Arrange
        $moon_phase = Phase::FirstQuarter;
        $corresponding_strategy = FirstQuarter::class;

        // Act & Assert
        $this->assertEquals($corresponding_strategy, Phase::getCorrespondingStrategy($moon_phase));
    }

    #[TestDox("maps the ThirdQuarter constant to the ThirdQuarter strategy.")]
    public function test_map_third_quarter_type()
    {
        // Arrange
        $moon_phase = Phase::ThirdQuarter;
        $corresponding_strategy = ThirdQuarter::class;

        // Act & Assert
        $this->assertEquals($corresponding_strategy, Phase::getCorrespondingStrategy($moon_phase));
    }

    #[TestDox("maps the FullMoon constant to the FullMoon strategy.")]
    public function test_map_full_moon_type()
    {
        // Arrange
        $moon_phase = Phase::FullMoon;
        $corresponding_strategy = FullMoon::class;

        // Act & Assert
        $this->assertEquals($corresponding_strategy, Phase::getCorrespondingStrategy($moon_phase));
    }

    #[TestDox("can't map unregistered PhaseStrategy.")]
    public function test_cant_map_unknown_moon_phase_strategy()
    {
        // Arrange
        $fake_strategy = Angle::class;
        $moon_phase_enum = Phase::class;
        $non_existent_class = NonExistentMoonStrategy::class;
        $failure_message = "If the strategy is not registered in $moon_phase_enum, it must return null.";

        // Act
        $moon_phase_1 = Phase::getCorrespondingType($fake_strategy);
        $moon_phase_2 = Phase::getCorrespondingType($non_existent_class);

        // Assert
        $this->assertNull($moon_phase_1, $failure_message);
        $this->assertNull($moon_phase_2, $failure_message);
    }
}