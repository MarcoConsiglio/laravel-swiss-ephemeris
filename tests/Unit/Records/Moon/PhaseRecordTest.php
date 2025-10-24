<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Records\Moon;

use MarcoConsiglio\Ephemeris\Enums\Moon\Phase;
use MarcoConsiglio\Ephemeris\Records\Moon\PhaseRecord;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithCustomAssertions;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The Moon\PhaseRecord")]
#[CoversClass(PhaseRecord::class)]
class PhaseRecordTest extends TestCase
{
    #[TestDox("has read-only property \"type\" which is a Phase.")]
    public function test_type_property()
    {
        // Arrange
        $moon_phase_type = $this->faker->randomElement(Phase::cases());
        $timestamp = $this->getMockedSwissEphemerisDateTime();

        // Act
        $moon_phase_record = new PhaseRecord($timestamp, $moon_phase_type);

        // Act
        $actual_phase_type = $moon_phase_record->type;

        // Assert
        $this->assertProperty("type", $moon_phase_type, Phase::class, $actual_phase_type);
    }

    #[TestDox("has read-only property \"timestamp\" which is a SwissEphemerisDateTime.")]
    public function test_timestamp_property()
    {
        // Arrange
        $moon_phase_type = $this->faker->randomElement(Phase::cases());
        $timestamp = $this->getMockedSwissEphemerisDateTime();

        // Act
        $moon_phase_record = new PhaseRecord($timestamp, $moon_phase_type);

        // Act
        $actual_timestamp = $moon_phase_record->timestamp;

        // Assert
        $this->assertProperty("timestamp", $timestamp, SwissEphemerisDateTime::class, $actual_timestamp);
    }
}