<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Phases\Strategies;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Phases\ThirdQuarter;

#[TestDox("The ThirdQuarter PhaseStrategy")]
#[CoversClass(ThirdQuarter::class)]
#[UsesClass(SynodicRhythmRecord::class)]
class ThirdQuarterTest extends TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->tested_class = ThirdQuarter::class;
        $this->record_class = SynodicRhythmRecord::class;
        parent::setUp();
    }

    #[TestDox("can find a Moon\SynodicRhythmRecord whose \"angular_distance\" is about -90°.")]
    public function test_can_find_third_quarter_if_angular_distance_is_about_minus_90()
    {
        // Arrange
        $record_90 = $this->getThirdQuarterRecord();
        $record_non_90 = $this->getNonThirdQuarterRecord();

        // Act
        $strategy = $this->makeStrategy($record_90);
        $this->checkStrategyImplementsInterface($strategy);
        $this->checkStrategyExtendsAbstract($strategy);
        $actual_record_90 = $strategy->found();
        $strategy = $this->makeStrategy($record_non_90);
        $actual_record_non_90 = $strategy->found();

        // Assert
        $this->assertRecordFound($record_90, $actual_record_90);
        $this->assertRecordNotFound($actual_record_non_90);
    }
}