<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Records\Moon;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Goniometry\Angle;

#[CoversClass(PerigeeRecord::class)]
#[UsesClass(Angle::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
#[TestDox("The Moon\PerigeeRecord")]
class PerigeeRecordTest extends TestCase
{
    #[TestDox("has a \"timestamp\" property which is a SwissEphemerisDateTime.")]
    public function test_timestamp_property()
    {
        // Arrange
        $timestamp = SwissEphemerisDateTime::create();
        $moon_longitude = Angle::createFromDecimal(179.0);
        $perigee_longitude= Angle::createFromDecimal(180.0);

        // Act
        $record = new PerigeeRecord($timestamp, $moon_longitude, $perigee_longitude);

        // Assert
        $this->assertProperty("timestamp", $timestamp, SwissEphemerisDateTime::class, $record->timestamp);
    }

    #[TestDox("has \"moon_longitude\" and \"perigee_longituded\" property which are Angle.")]
    public function test_moon_and_apogee_longitude_properties()
    {
        // Arrange
        $timestamp = SwissEphemerisDateTime::create();
        $moon_longitude = Angle::createFromDecimal(179.0);
        $perigee_longitude= Angle::createFromDecimal(180.0);

        // Act
        $record = new PerigeeRecord($timestamp, $moon_longitude, $perigee_longitude);

        // Assert
        $this->assertProperty("moon_longitude", $moon_longitude, Angle::class, $record->moon_longitude);
        $this->assertProperty("perigee_longituded", $perigee_longitude, Angle::class, $record->perigee_longitude);
    }

    #[TestDox("can establish equality with another record of the same type.")]
    public function test_is_equal()
    {
        // Arrange
        $a1 = Angle::createFromDecimal(90.0);
        $a2 = Angle::createFromDecimal(180.0);
        $d1 = SwissEphemerisDateTime::create(2000);
        $d2 = clone $d1;
        $d2->hour = 2;
        $record_A1 = new PerigeeRecord($d1, $a1, $a1);
        $record_A2 = new PerigeeRecord($d1, $a1, $a1);
        $record_B1 = new PerigeeRecord($d1, $a1, $a2);
        $record_B2 = new PerigeeRecord($d2, $a2, $a1);
        $record_C1 = new PerigeeRecord($d1, $a1, $a1);
        $record_C2 = new PerigeeRecord($d2, $a2, $a1);
        $record_D1 = new PerigeeRecord($d1, $a1, $a1);
        $record_D2 = new PerigeeRecord($d2, $a1, $a2);
        $record_E1 = new PerigeeRecord($d1, $a1, $a1);
        $record_E2 = new PerigeeRecord($d2, $a1, $a1);
        $record_F1 = new PerigeeRecord($d1, $a1, $a1);
        $record_F2 = new PerigeeRecord($d1, $a2, $a2);
        $record_G1 = new PerigeeRecord($d1, $a1, $a1);
        $record_G2 = new PerigeeRecord($d1, $a2, $a1);
        $record_H1 = new PerigeeRecord($d1, $a1, $a1);
        $record_H2 = new PerigeeRecord($d1, $a1, $a2);

        // Act & Assert
        //      0 means different, 1 means equal
        //      A = 1   B = 1   C = 1
        $this->assertObjectEquals($record_A1, $record_A2);
        //      A = 0   B = 0   C = 0
        $this->assertObjectNotEquals($record_B1, $record_B2);
        //      A = 0   B = 0   C = 1
        $this->assertObjectNotEquals($record_C1, $record_C2);
        //      A = 0   B = 1   C = 0
        $this->assertObjectNotEquals($record_D1, $record_D2);
        //      A = 0   B = 1   C = 1
        $this->assertObjectNotEquals($record_E1, $record_E2);
        //      A = 1   B = 0   C = 0
        $this->assertObjectNotEquals($record_F1, $record_F2);
        //      A = 1   B = 0   C = 1
        $this->assertObjectNotEquals($record_G1, $record_G2);
        //      A = 1   B = 1   C = 0
        $this->assertObjectNotEquals($record_H1, $record_H2);
    }
}