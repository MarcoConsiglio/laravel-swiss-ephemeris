<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Records\Moon;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithRecordsComparison;
use MarcoConsiglio\Goniometry\Angle;
use PHPUnit\Framework\MockObject\MockObject;

#[CoversClass(ApogeeRecord::class)]
#[UsesClass(Angle::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
#[TestDox("The Moon ApogeeRecord")]
class ApogeeRecordTest extends TestCase
{
    use WithRecordsComparison;

    #[TestDox("has a \"timestamp\" property which is a SwissEphemerisDateTime.")]
    public function test_timestamp_property(): void
    {
        // Arrange
        $timestamp = SwissEphemerisDateTime::create();
        /** @var Angle&MockObject $moon_longitude */
        $moon_longitude = $this->getMocked(Angle::class);
        /** @var Angle&MockObject $apogee_longitude */
        $apogee_longitude= $this->getMocked(Angle::class);
        $record = new ApogeeRecord($timestamp, $moon_longitude, $apogee_longitude, 12.0);

        // Act & Assert
        $this->assertProperty("timestamp", $timestamp, SwissEphemerisDateTime::class, $record->timestamp);
    }

    #[TestDox("has \"moon_longitude\" and \"apogee_longituded\" property which are Angle.")]
    public function test_moon_and_apogee_longitude_properties(): void
    {
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $timestamp */
        $timestamp = $this->getMockedSwissEphemerisDateTime();
        $moon_longitude = $this->getRandomPositiveAngle();
        $apogee_longitude= $this->getRandomPositiveAngle();
        $record = new ApogeeRecord($timestamp, $moon_longitude, $apogee_longitude, 12.0);

        // Act & Assert
        $this->assertProperty("moon_longitude", $moon_longitude, Angle::class, $record->moon_longitude);
        $this->assertProperty("apogee_longituded", $apogee_longitude, Angle::class, $record->apogee_longitude);
    }

    #[TestDox("has \"daily_speed\" property which is a float.")]
    public function test_moon_daily_speed_property(): void
    {
        // Arrange
        $timestamp = SwissEphemerisDateTime::create();
        /** @var Angle&MockObject $moon_longitude */
        $moon_longitude = $this->getMocked(Angle::class);
        /** @var Angle&MockObject $apogee_longitude */
        $apogee_longitude= $this->getMocked(Angle::class);
        $moon_daily_speed = $this->getRandomMoonDailySpeed();
        $record = new ApogeeRecord($timestamp, $moon_longitude, $apogee_longitude, $moon_daily_speed);

        // Act & Assert
        $this->assertProperty("daily_speed", $moon_daily_speed, "float", $record->daily_speed);
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
        $apogee_longitude = $this->getRandomPositiveAngle();
        $moon_daily_speed = $this->getRandomMoonDailySpeed();
        $record = new ApogeeRecord($timestamp, $moon_longitude, $apogee_longitude, $moon_daily_speed);
        $timestamp = $timestamp->toDateTimeString();
        $moon_longitude = $moon_longitude->toDecimal();
        $apogee_longitude = $apogee_longitude->toDecimal();

        // Act & Assert
        $this->assertEquals(<<<TEXT
ApogeeRecord
apogee_longitude: {$apogee_longitude}°
daily_speed: {$moon_daily_speed}°/day
moon_longitude: {$moon_longitude}°
timestamp: $timestamp

TEXT,
            (string) $record
        );
    }      

    /**
     * Return a comparison dataset with different and equal arguments.
     */
    protected function getComparisonDataset(): array
    {
        $angle_1 = Angle::createFromDecimal(90.0);
        $angle_2 = Angle::createFromDecimal(180.0);
        $date_1 = SwissEphemerisDateTime::create(2000);
        $date_2 = clone $date_1;
        $date_2->hour = 2;
        $speed_1 = 12.0;
        $speed_2 = 13.0;
        return [
            0 => [ 
                self::DIFFERENT => [$date_1, $date_2],
                self::EQUAL => [$date_1, $date_1]
            ],
            1 => [
                self::DIFFERENT => [$angle_1, $angle_2],
                self::EQUAL => [$angle_1, $angle_1]
            ],
            2 => [
                self::DIFFERENT => [$angle_1, $angle_2],
                self::EQUAL => [$angle_1, $angle_1]
            ],
            3 => [
                self::DIFFERENT => [$speed_1, $speed_2],
                self::EQUAL => [$speed_1, $speed_1]
            ]
        ];
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
            new ApogeeRecord(
                $property_couples[0][$first],
                $property_couples[1][$first],
                $property_couples[2][$first],
                $property_couples[3][$first]
            ),
            new ApogeeRecord(
                $property_couples[0][$second],
                $property_couples[1][$second],
                $property_couples[2][$second],
                $property_couples[3][$second]
            )
        ];
    }
}