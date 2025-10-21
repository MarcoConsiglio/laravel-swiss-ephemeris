<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\MoonPhases\Strategies;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\ThirdQuarter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The ThirdQuarter strategy")]
#[CoversClass(ThirdQuarter::class)]
class ThirdQuarterTest extends StrategyTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->tested_class = ThirdQuarter::class;
        parent::setUp();
    }

    #[TestDox("can find a MoonSynodicRhythmRecord whose 'angular_distance' is about -90°.")]
    public function test_can_find_third_quarter_if_angular_distance_is_about_minus_90()
    {
        // Arrange
        // Generate two records, one has -90 and the other has non-90 angular distance.
        $record_90 = $this->getThirdQuarterRecord();
        $record_non_90 = $this->getNonThirdQuarterRecord();

        // Act
        $strategy = $this->makeStrategy($record_90);
        $this->assertInstanceOf(BuilderStrategy::class, $strategy, "The {$this->strategy_name} strategy must realize BuilderStrategy interface.");
        $actual_record_90 = $strategy->found();
        $strategy = $this->makeStrategy($record_non_90);
        $actual_record_non_90 = $strategy->found();

        // Assert
        $this->assertRecordFound($record_90, $actual_record_90);
        $this->assertRecordNotFound($actual_record_non_90);
    }
}