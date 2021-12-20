<?php

namespace Tests\Unit;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Rhythms\WaxingMoonPeriod;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithFailureMessage;
use PHPUnit\Framework\TestCase;

/**
 * A Waxing Moon Period
 */
class WaxingMoonPeriodTest extends TestCase
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
        $period = new WaxingMoonPeriod($start_timestamp, $end_timestamp);
        $actual_start = $period->start_timestamp;
        $actual_end = $period->end_timestamp;

        // Assert
        $this->assertInstanceOf(Carbon::class, $actual_start, $this->typeFail("start_timestamp"));
        $this->assertEquals($start_timestamp, $actual_start, $this->getterFail("start_timestamp"));
        $this->assertInstanceOf(Carbon::class, $actual_end, $this->typeFail("end_timestamp"));
        $this->assertEquals($end_timestamp, $actual_end, $this->getterFail("end_timestamp"));
    }
}
