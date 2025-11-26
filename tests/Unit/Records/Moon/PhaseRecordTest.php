<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Records\Moon;

use MarcoConsiglio\Ephemeris\Enums\Moon\Phase;
use MarcoConsiglio\Ephemeris\Records\Moon\PhaseRecord;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;

#[TestDox("The Moon\PhaseRecord")]
#[CoversClass(PhaseRecord::class)]
class PhaseRecordTest extends TestCase
{
    #[TestDox("has read-only property \"type\" which is a Phase.")]
    public function test_type_property()
    {
        // Arrange
        $moon_phase_type = $this->faker->randomElement(Phase::cases());
        /** @var SwissEphemerisDateTime&MockObject $timestamp */
        $timestamp = $this->getMocked(SwissEphemerisDateTime::class);
        $moon_phase_record = new PhaseRecord($timestamp, $moon_phase_type);

        // Act & Assert
        $this->assertProperty("type", $moon_phase_type, Phase::class, $moon_phase_record->type);
    }

    #[TestDox("has read-only property \"timestamp\" which is a SwissEphemerisDateTime.")]
    public function test_timestamp_property()
    {
        // Arrange
        $moon_phase_type = $this->faker->randomElement(Phase::cases());
        $timestamp = SwissEphemerisDateTime::create();
        $moon_phase_record = new PhaseRecord($timestamp, $moon_phase_type);

        // Act & Assert
        $this->assertProperty("timestamp", $timestamp, SwissEphemerisDateTime::class, $moon_phase_record->timestamp);
    }
}