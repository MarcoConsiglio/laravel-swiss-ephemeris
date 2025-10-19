<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit;

use MarcoConsiglio\Ephemeris\Rhythms\MoonPhaseRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithCustomAssertions;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("A MoonPhaseRecord")]
#[CoversClass(MoonPhaseRecord::class)]
class MoonPhaseRecordTest extends TestCase
{
    use WithCustomAssertions;

    #[TestDox("has read-only properties 'type' and 'timestamp'.")]
    public function test_getters()
    {
        // Arrange
        $moon_phase_type = fake()->randomElement(MoonPhaseType::cases());
        $timestamp = (new SwissEphemerisDateTime)->minutes(0)->seconds(0);
        $moon_phase_record = new MoonPhaseRecord($timestamp, $moon_phase_type);

        // Act
        $actual_timestamp = $moon_phase_record->timestamp;
        $actual_moon_phase_type = $moon_phase_record->type;

        // Assert
        $this->assertProperty("type", $moon_phase_type, MoonPhaseType::class, $actual_moon_phase_type);
        $this->assertProperty("timestamp", $timestamp, SwissEphemerisDateTime::class, $actual_timestamp);
    }
}