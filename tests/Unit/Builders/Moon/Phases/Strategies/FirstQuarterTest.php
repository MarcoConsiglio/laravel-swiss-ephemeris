<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\Moon\Phases\Strategies;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\FirstQuarter;

#[TestDox("The FirstQuarter PhaseStrategy")]
#[CoversClass(FirstQuarter::class)]
#[UsesClass(SynodicRhythmRecord::class)]
class FirstQuarterTest extends PhaseStrategyTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->tested_class = FirstQuarter::class;
        parent::setUp();
    }

    #[TestDox("can find a Moon\SynodicRhythmRecord whose \"angular_distance\" is about 90°.")]
    public function test_can_find_first_quarter_moon_if_angular_distance_is_about_90()
    {
        // Arrange in setUp()
        // Generate two records, one has 90 and non-90 angular_distance.
        $record_90 = $this->getFirstQuarterRecord();
        $record_non_90 = $this->getNonFirstQuarterRecord();

        // Act
        $strategy = $this->makeStrategy($record_90);
        //      Guard Assertions
        $this->assertInstanceOf($this->strategy_interface, $strategy, 
            $this->mustImplement($this->tested_class, $this->strategy_interface)
        );
        $this->assertInstanceOf($this->abstract_strategy, $strategy, 
            $this->mustExtend($this->tested_class, $this->abstract_strategy)
        );
        $actual_record_90 = $strategy->found();
        $strategy = $this->makeStrategy($record_non_90);
        $actual_record_non_90 = $strategy->found();

        // Assert
        $this->assertRecordFound($record_90, $actual_record_90);
        $this->assertRecordNotFound($actual_record_non_90);
    }
}