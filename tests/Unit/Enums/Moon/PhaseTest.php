<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Enums\Moon;

use Error;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\FullMoon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\FirstQuarter;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\NewMoon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\ThirdQuarter;
use MarcoConsiglio\Ephemeris\Enums\Moon\Phase;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithFailureMessage;
use MarcoConsiglio\Ephemeris\Tests\Unit\Dummy\NonExistentMoonStrategy;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Goniometry\Angle;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Phase::class)]
#[TestDox("The PhaseType enumeration")]
class PhaseTest extends TestCase
{
    use WithFailureMessage;

    #[TestDox("has a new moon constant.")]
    public function test_new_moon_phase()
    {
        try {
            // Act
            $constant = Phase::NewMoon;

            // Assert
            $this->addToAssertionCount(1);
        } catch (\Error $error) {
            $this->fail($error->getMessage());
        }
    }

    #[TestDox("has a first quarter constant.")]
    public function test_first_quarter_phase()
    {
        try {
            // Act
            $constant = Phase::FirstQuarter;

            // Assert
            $this->addToAssertionCount(1);
        } catch (\Error $error) {
            $this->fail($error->getMessage());
        }
    }

    #[TestDox("has a third quarter constant.")]
    public function test_third_quarter_phase()
    {
        try {
            // Act
            $constant = Phase::ThirdQuarter;

            // Assert
            $this->addToAssertionCount(1);
        } catch (\Error $error) {
            $this->fail($error->getMessage());
        }
    }

    #[TestDox("has a full moon constant.")]
    public function test_full_moon_phase()
    {
        try {
            // Act
            $constant = Phase::FullMoon;

            // Assert
            $this->addToAssertionCount(1);
        } catch (\Error $error) {
            $this->fail($error->getMessage());
        }
    }

    #[TestDox("maps a PhaseStrategy to its Phase constant.")]
    public function test_map_new_moon_strategy()
    {
        $this->testPhaseConstantMapToPhaseStrategy(Phase::NewMoon, NewMoon::class);
        $this->testPhaseConstantMapToPhaseStrategy(Phase::FirstQuarter, FirstQuarter::class);
        $this->testPhaseConstantMapToPhaseStrategy(Phase::FullMoon, FullMoon::class);
        $this->testPhaseConstantMapToPhaseStrategy(Phase::ThirdQuarter, ThirdQuarter::class);
    }

    #[TestDox("maps a Phase constant to its PhaseStrategy.")]
    public function test_map_new_moon_type()
    {
        $this->testPhaseStrategyMapToPhaseConstant(NewMoon::class, Phase::NewMoon);  
        $this->testPhaseStrategyMapToPhaseConstant(FirstQuarter::class, Phase::FirstQuarter);  
        $this->testPhaseStrategyMapToPhaseConstant(FullMoon::class, Phase::FullMoon);  
        $this->testPhaseStrategyMapToPhaseConstant(ThirdQuarter::class, Phase::ThirdQuarter);  
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
        $moon_phase_1 = Phase::getCorrespondingPhase($fake_strategy);
        $moon_phase_2 = Phase::getCorrespondingPhase($non_existent_class);

        // Assert
        $this->assertNull($moon_phase_1, $failure_message);
        $this->assertNull($moon_phase_2, $failure_message);
    }

    /**
     * Test a Phase constant correspond to its PhaseStrategy.
     * This is a Parameterized Test.
     *
     * @param Phase $enum_constant
     * @param string $strategy_class
     * @return void
     */
    protected function testPhaseConstantMapToPhaseStrategy(Phase $enum_constant, string $strategy_class)
    {
        // Arrange
        $constant_name = $enum_constant->name;

        // Act 
        $moon_phase = Phase::getCorrespondingPhase($strategy_class);

        // Assert
        $this->assertEquals($enum_constant, $moon_phase, 
            "The $strategy_class strategy class must corresponds to $constant_name enum constant."
        );
    }

    /**
     * Test a PhaseStrategy corresponds to its Phase constant.
     * This is a Parameterized Test.
     *
     * @param string $strategy_class
     * @param Phase $enum_constant
     * @return void
     */
    protected function testPhaseStrategyMapToPhaseConstant(string $strategy_class, Phase $enum_constant)
    {
        // Arrange
        $constant_name = $enum_constant->name;

        // Act
        $phase_strategy = Phase::getCorrespondingStrategy($enum_constant);

        // Assert
        $this->assertEquals($strategy_class, $phase_strategy, 
            "The $constant_name enum constant must corresponds to $phase_strategy strategy class."
        );
    }
}