<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Rhythms\MoonPhaseRecord;
use MarcoConsiglio\Ephemeris\Tests\TestCase;
use MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithFailureMessage;

/**
 * @testdox A MoonPhaseRecord
 */
class MoonPhaseRecordTest extends TestCase
{
    use WithFailureMessage;

    public function test_getters()
    {
        // Arrange
        $moon_phase_type = $this->faker->randomElement(MoonPhaseType::cases());
        $timestamp = new Carbon;
        $moon_phase_record = new MoonPhaseRecord($timestamp, $moon_phase_type);

        // Act
        $actual_timestamp = $moon_phase_record->timestamp;
        $actual_moon_phase_type = $moon_phase_record->type;

        // Assert
        $this->assertInstanceOf(MoonPhaseType::class, $actual_moon_phase_type, $this->typeFail("type"));
        $this->assertEquals($moon_phase_type, $actual_moon_phase_type, $this->getterFail("type"));
        $this->assertInstanceOf(Carbon::class, $actual_timestamp, $this->typeFail("timestamp"));
        $this->assertEquals($timestamp->toDateTimeString(), $actual_timestamp->toDateTimeString());
        $this->assertNull($moon_phase_record->sghidibudi, "What da fuck? A non existing property should be null.");
    }
}