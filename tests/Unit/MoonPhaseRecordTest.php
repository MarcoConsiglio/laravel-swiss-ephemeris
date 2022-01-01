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

    public function test_getters()
    {
        // Arrange
        $moon_phase_type = $this->faker->randomElement(MoonPhaseType::cases());
        $timestamp = (new Carbon)->minutes(0)->seconds(0);
        $moon_phase_record = new MoonPhaseRecord($timestamp, $moon_phase_type);

        // Act
        $actual_timestamp = $moon_phase_record->timestamp;
        $actual_moon_phase_type = $moon_phase_record->type;

        // Assert
        $this->assertProperty("type", $moon_phase_type, MoonPhaseType::class, $actual_moon_phase_type);
        $this->assertProperty("timestamp", $timestamp, Carbon::class, $actual_timestamp);
        $this->assertNull($moon_phase_record->sghidibudi, "What da fuck? A non existing property should be null.");
    }
}