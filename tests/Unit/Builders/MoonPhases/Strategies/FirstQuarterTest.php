<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\MoonPhases\Strategies;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\FirstQuarter;

/**
 * @testdox The FirstQuarter strategy
 */
class FirstQuarterTest extends StrategyTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->tested_class = class_basename(FirstQuarter::class);
    }

    /**
     * @testdox can find a SynodicRhythmRecord whose 'angular_distance' is about 90.
     */
    public function test_can_find_first_quarter_moon_if_angular_distance_is_about_90()
    {
        // Arrange in setUp()
        // Generate two records, one has 90 and non-90 angular_distance.
        $record_90 = $this->getFirstQuarterRecord();
        $record_non_90 = $this->getNonFirstQuarterRecord();

        // Act
        $strategy = new FirstQuarter($record_90);
        $this->assertInstanceOf(BuilderStrategy::class, $strategy, "The {$this->tested_class} strategy must realize BuilderStrategy interface.");
        $actual_record_90 = $strategy->findRecord();
        $strategy = new FirstQuarter($record_non_90);
        $actual_record_non_90 = $strategy->findRecord();

        // Assert
        $this->assertRecordFound($record_90, $actual_record_90);
        $this->assertRecordNotFound($actual_record_non_90);
    }
}