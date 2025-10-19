<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Enums;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\FullMoon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\FirstQuarter;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\NewMoon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\ThirdQuarter;
use MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType as MoonPhase;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithFailureMessage;
use MarcoConsiglio\Ephemeris\Tests\Unit\Dummy\NonExistentMoonStrategy;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Goniometry\Angle;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use Reflection;

#[CoversClass(MoonPhase::class)]
#[TestDox("The MoonPhaseType enumeration")]
class MoonPhaseTest extends TestCase
{
    use WithFailureMessage;

    #[DoesNotPerformAssertions]
    #[TestDox("has a new moon constant.")]
    public function test_new_moon_phase()
    {
        // Act
        $constant = MoonPhase::NewMoon;
    }

    #[DoesNotPerformAssertions]
    #[TestDox("has a first quarter constant.")]
    public function test_first_quarter_phase()
    {
        // Act
        $constant = MoonPhase::FirstQuarter;
    }

    #[DoesNotPerformAssertions]
    #[TestDox("has a third quarter constant.")]
    public function test_third_quarter_phase()
    {
        // Act
        $constant = MoonPhase::ThirdQuarter;
    }

    #[DoesNotPerformAssertions]
    #[TestDox("has a full moon constant.")]
    public function test_full_moon_phase()
    {
        // Act
        $constant = MoonPhase::FullMoon;
    }

    #[TestDox("maps the NewMoon strategy to the NewMoon constant.")]
    public function test_map_new_moon_strategy()
    {
        // Arrange
        $strategy = NewMoon::class;
        $constant_name = MoonPhase::NewMoon->name;

        // Act 
        $moon_phase = MoonPhase::getCorrespondingType($strategy);

        // Assert
        $this->assertEquals(MoonPhase::NewMoon, $moon_phase, "The NewMoon BuilderStrategy must corresponds to {$constant_name}.");
    }

    #[TestDox("maps the FirstQuarter strategy to the FirstQuarter constant.")]
    public function test_map_first_quarter_strategy()
    {
        // Arrange
        $strategy = FirstQuarter::class;
        $constant_name = MoonPhase::FirstQuarter->name;

        // Act 
        $moon_phase = MoonPhase::getCorrespondingType($strategy);

        // Assert
        $this->assertEquals(MoonPhase::FirstQuarter, $moon_phase, "The NewMoon BuilderStrategy must corresponds to {$constant_name}.");
    }

    #[TestDox("maps the FullMoon strategy to the FullMoon constant.")]
    public function test_map_full_moon_strategy()
    {
        // Arrange
        $strategy = FullMoon::class;
        $constant_name = MoonPhase::FullMoon->name;

        // Act 
        $moon_phase = MoonPhase::getCorrespondingType($strategy);

        // Assert
        $this->assertEquals(MoonPhase::FullMoon, $moon_phase, "The NewMoon BuilderStrategy must corresponds to {$constant_name}.");
    }

    #[TestDox("maps the ThirdQuarter strategy to the ThirdQuarter constant.")]
    public function test_map_third_quarter_strategy()
    {
        // Arrange
        $strategy = ThirdQuarter::class;
        $constant_name = MoonPhase::ThirdQuarter->name;

        // Act 
        $moon_phase = MoonPhase::getCorrespondingType($strategy);

        // Assert
        $this->assertEquals(MoonPhase::ThirdQuarter, $moon_phase, "The NewMoon BuilderStrategy must corresponds to {$constant_name}.");
    }

    #[TestDox("maps the NewMoon constant to the NewMoon strategy.")]
    public function test_map_new_moon_type()
    {
        // Arrange
        $moon_phase = MoonPhase::NewMoon;
        $corresponding_strategy = NewMoon::class;

        // Act & Assert
        $this->assertEquals($corresponding_strategy, MoonPhase::getCorrespondingStrategy($moon_phase));
    }

    #[TestDox("maps the FirstQuarter constant to the FirstQuarter strategy.")]
    public function test_map_first_quarter_type()
    {
        // Arrange
        $moon_phase = MoonPhase::FirstQuarter;
        $corresponding_strategy = FirstQuarter::class;

        // Act & Assert
        $this->assertEquals($corresponding_strategy, MoonPhase::getCorrespondingStrategy($moon_phase));
    }

    #[TestDox("maps the ThirdQuarter constant to the ThirdQuarter strategy.")]
    public function test_map_third_quarter_type()
    {
        // Arrange
        $moon_phase = MoonPhase::ThirdQuarter;
        $corresponding_strategy = ThirdQuarter::class;

        // Act & Assert
        $this->assertEquals($corresponding_strategy, MoonPhase::getCorrespondingStrategy($moon_phase));
    }

    #[TestDox("maps the FullMoon constant to the FullMoon strategy.")]
    public function test_map_full_moon_type()
    {
        // Arrange
        $moon_phase = MoonPhase::FullMoon;
        $corresponding_strategy = FullMoon::class;

        // Act & Assert
        $this->assertEquals($corresponding_strategy, MoonPhase::getCorrespondingStrategy($moon_phase));
    }

    #[TestDox("can't map unregistered MoonPhaseStrategy.")]
    public function test_cant_map_unknown_moon_phase_strategy()
    {
        // Arrange
        $fake_strategy = Angle::class;
        $moon_phase_enum = MoonPhaseTest::class;
        $non_existent_class = NonExistentMoonStrategy::class;
        $failure_message = "If the strategy is not registered in $moon_phase_enum, it must return null.";

        // Act
        $moon_phase_1 = MoonPhase::getCorrespondingType($fake_strategy);
        $moon_phase_2 = MoonPhase::getCorrespondingType($non_existent_class);

        // Assert
        $this->assertNull($moon_phase_1, $failure_message);
        $this->assertNull($moon_phase_2, $failure_message);
    }
}