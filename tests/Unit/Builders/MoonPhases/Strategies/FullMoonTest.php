<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\MoonPhases\Strategies;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\FullMoon;

/**
 * @testdox A FullMoon strategy
 */
class FullMoonTest extends StrategyTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->tested_class = class_basename(FullMoon::class);
    }

    /**
     * @testdox can find a SynodicRhythmRecord whose 'angular_distance' is about -/+180°.
     */
    public function test_can_find_full_moon_if_angular_distance_is_minus_or_plus_180()
    {
        // Arrange in setUp()
        // Generate two records, one tends to be +/-180°, the other wont. 
        $positive_record_180 = $this->getFullMoonRecord();
        $negative_record_180 = $this->getFullMoonRecord(false);
        $record_non_180 = $this->getNonFullMoonRecord();

        // Act
        $strategy = new FullMoon($positive_record_180);
        $this->assertInstanceOf(BuilderStrategy::class, $strategy, "The {$this->tested_class} strategy must realize BuilderStrategy interface.");
        $actual_positive_record_180 = $strategy->findRecord();
        $strategy = new FullMoon($negative_record_180);
        $actual_negative_record_180 = $strategy->findRecord();
        $strategy = new FullMoon($record_non_180);
        $actual_record_non_180 = $strategy->findRecord();

        // Assert
        $this->assertRecordFound($positive_record_180, $actual_positive_record_180);
        $this->assertRecordFound($negative_record_180, $actual_negative_record_180);
        $this->assertRecordNotFound($actual_record_non_180);
    }
}