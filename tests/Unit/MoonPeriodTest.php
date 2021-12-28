<?php

namespace MarcoConsiglio\Ephemeris\Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPeriod;
use MarcoConsiglio\Ephemeris\Tests\TestCase;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithFailureMessage;

/**
 * @testdox A MoonPeriod
 */
class MoonPeriodTest extends TestCase
{
    use WithFailureMessage;

    /**
     * @testdox has properties.
     */
    public function test_getters()
    {
        // Arrange
        $start = new Carbon("2021-06-10 13:00:00");
        $end = new Carbon("2021-06-24 21:00:00");
        $moon_period = new MoonPeriod($start, $end, MoonPeriod::WAXING);

        // Act
        $actual_start = $moon_period->start;
        $actual_end = $moon_period->end;

        // Assert
        $this->assertInstanceOf(Carbon::class, $actual_start, $this->typeFail("start"));
        $this->assertEquals($start, $actual_start, $this->getterFail("start"));
        $this->assertInstanceOf(Carbon::class, $actual_end, $this->typeFail("end"));
        $this->assertEquals($end, $actual_end, $this->getterFail("end"));
        $this->assertEquals(null, $moon_period->ace_ventura);
    }

    /**
     * @testdox can be a waxing one.
     */
    public function test_is_waxing()
    {
        // Arrange
        $start = new Carbon("2021-06-10 13:00:00");
        $end = new Carbon("2021-06-24 21:00:00");
        $moon_period = new MoonPeriod($start, $end, MoonPeriod::WAXING);

        // Act & Assert
        $this->assertTrue($moon_period->isWaxing(), "The testing moon period should be a waxing one but found the opposite.");
        $this->assertFalse($moon_period->isWaning(), "The testing moon period should not be a waning one but found the opposite.");
    }

    /**
     * @testdox can be a waning one.
     */
    public function test_is_waning()
    {
        // Arrange
        $start = new Carbon("2021-06-24 22:00:00");
        $end = new Carbon("2021-07-10 03:00:00");
        $moon_period = new MoonPeriod($start, $end, MoonPeriod::WANING);

        // Act & Assert
        $this->assertTrue($moon_period->isWaning(), "The testing moon period should be a waning one but found the opposite.");
        $this->assertFalse($moon_period->isWaxing(), "The testing moon period should not be a waxing one but found the opposite.");
    }
}