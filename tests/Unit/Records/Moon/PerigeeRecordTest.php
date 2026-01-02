<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Records\Moon;

use MarcoConsiglio\Goniometry\Angle;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithRecordsComparison;

#[CoversClass(PerigeeRecord::class)]

#[UsesClass(SwissEphemerisDateTime::class)]
#[TestDox("The Moon PerigeeRecord")]
class PerigeeRecordTest extends TestCase
{
    use WithRecordsComparison;

    #[TestDox("has a \"timestamp\" property which is a SwissEphemerisDateTime.")]
    public function test_timestamp_property(): void
    {
        // Arrange
        $timestamp = $this->getRandomSwissEphemerisDateTime();
        /** @var Angle&MockObject $moon_longitude */
        $moon_longitude = $this->getMocked(Angle::class);
        /** @var Angle&MockObject $perigee_longitude */
        $perigee_longitude= $this->getMocked(Angle::class);
        $record = new PerigeeRecord($timestamp, $moon_longitude, $perigee_longitude, 12.0);

        // Act & Assert
        $this->assertProperty("timestamp", $timestamp, SwissEphemerisDateTime::class, $record->timestamp);
    }

    #[TestDox("has \"moon_longitude\" and \"perigee_longituded\" property which are Angle.")]
    public function test_moon_and_apogee_longitude_properties(): void
    {
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $timestamp */
        $timestamp = $this->getMockedSwissEphemerisDateTime();
        $moon_longitude = $this->getRandomPositiveAngle();
        $perigee_longitude = $this->getRandomPositiveAngle();
        $record = new PerigeeRecord($timestamp, $moon_longitude, $perigee_longitude, 12.0);

        // Act & Assert
        $this->assertProperty("moon_longitude", $moon_longitude, Angle::class, $record->moon_longitude);
        $this->assertProperty("perigee_longituded", $perigee_longitude, Angle::class, $record->perigee_longitude);
    }

    #[TestDox("can establish equality with another record of the same type.")]
    public function test_equals_method(): void
    {
        $this->testEqualComparison(4);
    }

    #[TestDox("can be casted to string.")]
    public function test_casting_to_string(): void
    {
        // Arrange
        $timestamp = $this->getRandomSwissEphemerisDateTime();
        $moon_longitude = $this->getRandomPositiveAngle();
        $perigee_longitude = $this->getRandomPositiveAngle();
        $moon_daily_speed = $this->getRandomMoonDailySpeed();
        $record = new PerigeeRecord($timestamp, $moon_longitude, $perigee_longitude, $moon_daily_speed);
        $timestamp = $timestamp->toDateTimeString();
        $moon_longitude = $moon_longitude->toDecimal();
        $perigee_longitude = $perigee_longitude->toDecimal();

        // Act & Assert
        $this->assertEquals(<<<TEXT
PerigeeRecord
daily_speed: {$moon_daily_speed}°/day
moon_longitude: {$moon_longitude}°
perigee_longitude: {$perigee_longitude}°
timestamp: $timestamp

TEXT,
            (string) $record
        );
    }

    /**
     * Construct the two records to be compared with some $property_couples
     * Representsing an equal or different property
     */
    protected function getRecordsToCompare(array $property_couples): array
    {
        $first = 0;
        $second = 1;
        return [
            new PerigeeRecord(
                $property_couples[0][$first],
                $property_couples[1][$first],
                $property_couples[2][$first],
                $property_couples[3][$first],
            ),
            new PerigeeRecord(
                $property_couples[0][$second],
                $property_couples[1][$second],
                $property_couples[2][$second],
                $property_couples[3][$second]
            )
        ];
    }

    /**
     * Return a comparison dataset with different and equal arguments.
     */
    protected function getComparisonDataset(): array
    {        
        $angle_1 = $this->getSpecificAngle(90);
        $angle_2 = $this->getSpecificAngle(180);
        $date_1 = $this->getRandomSwissEphemerisDateTime();
        $date_2 = $date_1->clone()->addYear();
        $speed_1 = 12.0;
        $speed_2 = 13.0;
        return [
            0 => [ 
                self::DIFFERENT =>  [$date_1,  $date_2],
                self::EQUAL     =>  [$date_1,  $date_1]
            ],
            1 => [
                self::DIFFERENT =>  [$angle_1, $angle_2],
                self::EQUAL     =>  [$angle_1, $angle_1]
            ],
            2 => [
                self::DIFFERENT =>  [$angle_1, $angle_2],
                self::EQUAL     =>  [$angle_1, $angle_1]
            ], 
            3 => [
                self::DIFFERENT =>  [$speed_1, $speed_2],
                self::EQUAL     =>  [$speed_1, $speed_1]
            ]            
        ];
    }
}