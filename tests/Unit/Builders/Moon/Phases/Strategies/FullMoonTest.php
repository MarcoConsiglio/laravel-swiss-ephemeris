<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\Moon\Phases\Strategies;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\FullMoon;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("A FullMoon strategy")]
#[CoversClass(FullMoon::class)]
class FullMoonTest extends StrategyTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->tested_class = FullMoon::class;
        parent::setUp();
    }

    #[TestDox("can find a MoonSynodicRhythmRecord whose 'angular_distance' is about -/+180°.")]
    public function test_can_find_full_moon_if_angular_distance_is_minus_or_plus_180()
    {
        // Arrange in setUp()
        // Generate two records, one tends to be +/-180°, the other wont. 
        $positive_record_180 = $this->getFullMoonRecord();
        $negative_record_180 = $this->getFullMoonRecord(false);
        $record_non_180 = $this->getNonFullMoonRecord();

        // Act
        $strategy = $this->makeStrategy($positive_record_180);
        $this->assertInstanceOf(BuilderStrategy::class, $strategy, "The {$this->strategy_name} strategy must realize BuilderStrategy interface.");
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