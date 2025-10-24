<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Records\Moon;

use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Goniometry\Angle;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(ApogeeRecord::class)]
#[UsesClass(Angle::class)]
#[TestDox("The Moon\ApogeeRecord")]
class ApogeeRecordTest extends TestCase
{
    #[TestDox("has a \"timestamp\" property which is a SwissEphemerisDateTime.")]
    public function test_timestamp_property()
    {
        // Arrange
        $timestamp = $this->getMockedSwissEphemerisDateTime();
        $moon_longitude = Angle::createFromDecimal(179.0);
        $apogee_longitude= Angle::createFromDecimal(180.0);

        // Act
        $record = new ApogeeRecord($timestamp, $moon_longitude, $apogee_longitude);

        // Assert
        $this->assertProperty("timestamp", $timestamp, SwissEphemerisDateTime::class, $record->timestamp);
    }

    #[TestDox("has \"moon_longitude\" and \"apogee_longituded\" property which are Angle.")]
    public function test_moon_and_apogee_longitude_properties()
    {
        // Arrange
        $timestamp = $this->getMockedSwissEphemerisDateTime();
        $moon_longitude = Angle::createFromDecimal(179.0);
        $apogee_longitude= Angle::createFromDecimal(180.0);

        // Act
        $record = new ApogeeRecord($timestamp, $moon_longitude, $apogee_longitude);

        // Assert
        $this->assertProperty("moon_longitude", $moon_longitude, Angle::class, $record->moon_longitude);
        $this->assertProperty("apogee_longituded", $apogee_longitude, Angle::class, $record->apogee_longitude);
    }
}