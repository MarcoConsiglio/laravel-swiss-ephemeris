<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Phases\Strategies;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\FullMoon;

#[TestDox("The FullMoon PhaseStrategy")]
#[CoversClass(FullMoon::class)]
#[UsesClass(SynodicRhythmRecord::class)]
class FullMoonTest extends PhaseStrategyTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->tested_class = FullMoon::class;
        $this->record_class = SynodicRhythmRecord::class;
        parent::setUp();
    }

    #[TestDox("can find a Moon\SynodicRhythmRecord whose \"angular_distance\" is about -/+180°.")]
    public function test_can_find_full_moon_if_angular_distance_is_minus_or_plus_180()
    {
        // Arrange in setUp()
        $positive_record_180 = $this->getFullMoonRecord();
        $negative_record_180 = $this->getFullMoonRecord(false);
        $record_non_180 = $this->getNonFullMoonRecord();

        // Act
        $strategy = $this->makeStrategy($positive_record_180);
        $this->checkStrategyImplementsInterface($strategy);
        $this->checkStrategyExtendsAbstract($strategy);
        $actual_positive_record_180 = $strategy->found();
        $strategy = $this->makeStrategy($negative_record_180);
        $actual_negative_record_180 = $strategy->found();
        $strategy = $this->makeStrategy($record_non_180);
        $actual_record_non_180 = $strategy->found();

        // Assert
        $this->assertRecordFound($positive_record_180, $actual_positive_record_180);
        $this->assertRecordFound($negative_record_180, $actual_negative_record_180);
        $this->assertRecordNotFound($actual_record_non_180); 
    }
}