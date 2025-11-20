<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Phases\Strategies;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\NewMoon;

#[TestDox("The NewMoon PhaseStrategy")]
#[CoversClass(NewMoon::class)]
#[UsesClass(SynodicRhythmRecord::class)]
class NewMoonTest extends PhaseStrategyTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->tested_class = NewMoon::class;
        $this->record_class = SynodicRhythmRecord::class;
        $this->delta = $this->getDelta();
        parent::setUp();
    }

    #[TestDox("can find a Moon\SyndicRhythmRecord whose \"angular_distance\" is about 0°.")]
    public function test_can_find_new_moon_if_angular_distance_is_about_zero()
    {
        // Arrange in setUp()
        // Generate two record, one has zero and the other has non-zero angular distance.
        $record_zero = $this->getNewMoonRecord();
        $record_non_zero = $this->getNonNewMoonRecord();

        // Act
        $strategy = $this->makeStrategy($record_zero);
        $this->assertInstanceOf($this->strategy_interface, $strategy, 
            $this->mustImplement($this->tested_class, $this->strategy_interface)
        );
        $this->assertInstanceOf($this->abstract_strategy, $strategy,
            $this->mustExtend($this->tested_class, $this->abstract_strategy)
        );
        $actual_record_zero = $strategy->found();
        $strategy = $this->makeStrategy($record_non_zero);
        $actual_record_non_zero = $strategy->found();
        
        // Assert
        $this->assertRecordFound($record_zero, $actual_record_zero);
        $this->assertRecordNotFound($actual_record_non_zero);
    }
}