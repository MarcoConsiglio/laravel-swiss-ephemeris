<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Enums\Moon;

use Error;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Enums\Moon\Phase;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Phases\FirstQuarter;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Phases\FullMoon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Phases\NewMoon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Phases\ThirdQuarter;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithFailureMessage;
use MarcoConsiglio\Ephemeris\Tests\Unit\Dummy\NonExistentMoonStrategy;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Goniometry\Angle;

#[CoversClass(Phase::class)]
#[UsesClass(Angle::class)]
#[UsesClass(NonExistentMoonStrategy::class)]
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
            $this->assertInstanceOf(Phase::class, $constant);
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
            $this->assertInstanceOf(Phase::class, $constant);
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
            $this->assertInstanceOf(Phase::class, $constant);
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
            $this->assertInstanceOf(Phase::class, $constant);
        } catch (\Error $error) {
            $this->fail($error->getMessage());
        }
    }

    #[TestDox("maps a PhaseStrategy to its Phase constant.")]
    public function test_map_phase_strategy_to_its_phase_constant()
    {
        $this->testPhaseConstantMapToPhaseStrategy(Phase::NewMoon, NewMoon::class);
        $this->testPhaseConstantMapToPhaseStrategy(Phase::FirstQuarter, FirstQuarter::class);
        $this->testPhaseConstantMapToPhaseStrategy(Phase::FullMoon, FullMoon::class);
        $this->testPhaseConstantMapToPhaseStrategy(Phase::ThirdQuarter, ThirdQuarter::class);
    }

    #[TestDox("maps a Phase constant to its PhaseStrategy.")]
    public function test_map_phase_constant_to_its_phase_strategy()
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
        $non_existent_class = NonExistentMoonStrategy::class;
        $empty_string = "";
        $random_string = $this->faker->text(15);
        $failure_message = $this->methodMustReturnIf(
            Phase::class, "getCorrespondingPhase", "null", "the strategy is unregistered."
        );

        // Act
        $moon_phase_1 = Phase::getCorrespondingPhase($fake_strategy);
        $moon_phase_2 = Phase::getCorrespondingPhase($non_existent_class);
        $moon_phase_3 = Phase::getCorrespondingPhase($empty_string);
        $moon_phase_4 = Phase::getCorrespondingPhase($random_string);

        // Assert
        $this->assertNotInstanceOf(Phase::class, $moon_phase_1);
        $this->assertNotInstanceOf(Phase::class, $moon_phase_2);
        $this->assertNotInstanceOf(Phase::class, $moon_phase_3);
        $this->assertNotInstanceOf(Phase::class, $moon_phase_4);
        $this->assertNull($moon_phase_1, $failure_message);
        $this->assertNull($moon_phase_2, $failure_message);
        $this->assertNull($moon_phase_3, $failure_message);
        $this->assertNull($moon_phase_4, $failure_message);
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