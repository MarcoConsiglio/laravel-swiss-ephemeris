<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\MoonPhases\Strategies;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\NewMoon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The NewMoon strategy")]
#[CoversClass(NewMoon::class)]
class NewMoonTest extends StrategyTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->tested_class = NewMoon::class;
        parent::setUp();
    }

    #[TestDox("can find a SyndicRhythmRecord whose 'angular_distance' is about zero.")]
    public function test_can_find_new_moon_if_angular_distance_is_about_zero()
    {
        // Arrange in setUp()
        // Generate two record, one has zero and the other has non-zero angular distance.
        $record_zero = $this->getNewMoonRecord();
        $record_non_zero = $this->getNonNewMoonRecord();

        // Act
        $strategy = $this->makeStrategy($record_zero);
        $this->assertInstanceOf(BuilderStrategy::class, $strategy, "The {$this->strategy_name} strategy must realize BuilderStrategy interface.");
        $actual_record_zero = $strategy->found();
        $strategy = $this->makeStrategy($record_non_zero);
        $actual_record_non_zero = $strategy->found();
        
        // Assert
        $this->assertRecordFound($record_zero, $actual_record_zero);
        $this->assertRecordNotFound($actual_record_non_zero);
    }
}