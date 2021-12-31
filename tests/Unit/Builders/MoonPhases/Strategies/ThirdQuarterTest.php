<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\MoonPhases\Strategies;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\ThirdQuarter;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Tests\TestCase;

/**
 * @testdox The ThirdQuarter strategy
 */
class ThirdQuarterTest extends TestCase
{
    /**
     * @testdox can find a SynodicRhythmRecord whose 'angular_distance' is about -90°.
     */
    public function test_can_find_third_quarter_if_angular_distance_is_about_minus_90()
    {
        // Arrange
        $delta = 1;
        $min = -90 - $delta;
        $max = -90 + $delta;
        $date = (new Carbon)->minutes(0)->seconds(0)->format("d.m.Y H:m:i")." UT";
        // Generate two records, one has -90 and the other has non-90 angular distance.
        $record_90 = new SynodicRhythmRecord($date, $this->faker->randomFloat(1, $min, $max));
        $record_non_90 = new SynodicRhythmRecord($date, $this->faker->randomElement([
            $this->faker->randomFloat(1, -180, $min),
            $this->faker->randomFloat(1, $max, 180)
        ]));

        // Act
        $strategy = new ThirdQuarter($record_90);
        $this->assertInstanceOf(BuilderStrategy::class, $strategy, "The ThirdQuarter strategy must realize BuilderStrategy interface.");
        $actual_record_90 = $strategy->findRecord();
        $strategy = new ThirdQuarter($record_non_90);
        $actual_record_non_90 = $strategy->findRecord();

        // Assert
        $this->assertInstanceOf(SynodicRhythmRecord::class, $actual_record_90, "The ThirdQuarter strategies must find a SynodicRhythmRecord.");
        $this->assertObjectEquals($record_90, $actual_record_90, "equals", "The ThirdQuarter strategy failed to find the correct record.");
    }
}