<?php

namespace Tests\Unit;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Rhythms\WaningMoonPeriod;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithFailureMessage;
use PHPUnit\Framework\TestCase;

/**
 * A Waning Moon Period
 */
class WaningMoonPeriodTest extends TestCase
{
    use WithFailureMessage;
    
    /**
     * @testdox has public properties.
     */
    public function test_getters()
    {
        // Arrange
        $start_timestamp = (new Carbon())->hours(0)->minutes(0)->seconds(0);
        $end_timestamp = $start_timestamp->copy()->addDays(15);

        // Act
        $waning_moon_period = new WaningMoonPeriod($start_timestamp, $end_timestamp);
        $actual_start = $waning_moon_period->start_timestamp;
        $actual_end = $waning_moon_period->end_timestamp;

        // Assert
        $this->assertInstanceOf(Carbon::class, $actual_start, $this->typeFail("start_timestamp"));
        $this->assertEquals($start_timestamp, $actual_start, $this->getterFail("start_timestamp"));
        $this->assertInstanceOf(Carbon::class, $actual_end, $this->typeFail("end_timestamp"));
        $this->assertEquals($end_timestamp, $actual_end, $this->getterFail("end_timestamp"));
    }
}
