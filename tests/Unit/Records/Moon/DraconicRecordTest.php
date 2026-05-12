<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Records\Moon;

use MarcoConsiglio\Goniometry\Angle;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\Enums\Cardinality;
use MarcoConsiglio\Ephemeris\Records\DailySpeed;
use MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Traits\RecordsComparison;
use MarcoConsiglio\Goniometry\Enums\Rotation;

#[CoversClass(DraconicRecord::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
#[TestDox("The Moon DraconicRecord")]
class DraconicRecordTest extends TestCase
{
    use RecordsComparison;

    #[TestDox("has a \"timestamp\" property which is a SwissEphemerisDateTime.")]
    public function test_timestamp_property(): void
    {
        // Arrange
        $datetime = $this->getRandomSwissEphemerisDateTime();
        /** @var Angle&MockObject $angle */
        $angle = $this->getMocked(Angle::class);
        $daily_speed = $this->createMock(DailySpeed::class);
        $record = new DraconicRecord($datetime, $angle, $angle, $daily_speed);

        // Act & Assert
        $this->assertProperty("timestamp", $datetime, SwissEphemerisDateTime::class, $record->timestamp);
    }

    #[TestDox("has a \"moon_longitude\", \"north_node_longitude\", \"south_node_longitude\", properties which are Angle(s).")]
    public function test_moon_longitude_property(): void
    {
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $datetime */
        $datetime = $this->getMockedSwissEphemerisDateTime();
        $moon_longitude = Angle::createFromValues(180);
        $north_node_longitude = Angle::createFromValues(180);
        $opposite = Angle::createFromValues(180, direction: Rotation::CLOCKWISE);
        $south_node_longitude = $north_node_longitude->absSum($opposite);
        $daily_speed = $this->createMock(DailySpeed::class);
        $record = new DraconicRecord($datetime, $moon_longitude, $north_node_longitude, $daily_speed);

        // Act & Assert
        $this->assertProperty("moon_longitude", $moon_longitude, Angle::class, $record->moon_longitude);
        $this->assertProperty("north_node_longitude", $north_node_longitude, Angle::class, $record->north_node_longitude);
        $this->assertProperty("south_node_longitude", $south_node_longitude, Angle::class, $record->south_node_longitude);
    }

    #[TestDox("has a \"daily_speed\" property which is a float.")]
    public function test_daily_speed_property(): void
    {
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $datetime */
        $datetime = $this->getMockedSwissEphemerisDateTime();
        /** @var Angle&MockObject $angle */
        $angle = $this->createMock(Angle::class);
        $moon_daily_speed = $this->getRandomMoonDailySpeed();
        $record = new DraconicRecord($datetime, $angle, $angle, $moon_daily_speed);

        // Act & Assert
        $this->assertProperty("daily_speed", $moon_daily_speed, DailySpeed::class, $record->daily_speed);
    }

    #[TestDox("has a \"cardinality\" property which is a Cardinality enumeration.")]
    public function test_cardinality_property(): void
    {
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $datetime */
        $datetime = $this->getMockedSwissEphemerisDateTime();
        /** @var Angle&MockObject $angle */
        $angle = $this->createMock(Angle::class);
        $moon_daily_speed = $this->getRandomMoonDailySpeed();
        $north_record = new DraconicRecord($datetime, $angle, $angle, $moon_daily_speed);
        $south_record = new DraconicRecord($datetime, $angle, $angle, $moon_daily_speed);
        $north_record->cardinality = Cardinality::North;
        $south_record->cardinality = Cardinality::South;

        // Act & Assert
        $this->assertProperty("cardinality", Cardinality::North, Cardinality::class, $north_record->cardinality);
        $this->assertProperty("cardinality", Cardinality::South, Cardinality::class, $south_record->cardinality);
    }

    #[TestDox("can be a north node.")]
    public function test_is_north_node(): void
    {
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $datetime */
        $datetime = $this->getMockedSwissEphemerisDateTime();
        /** @var Angle&MockObject $angle */
        $angle = $this->createMock(Angle::class);
        $daily_speed = $this->createMock(DailySpeed::class);
        $record = new DraconicRecord($datetime, $angle, $angle, $daily_speed);
        $record->cardinality = Cardinality::North;
        // This checks that the property is immutable.
        $record->cardinality = Cardinality::South;

        // Act & Assert
        $this->assertTrue($record->isNorthNode());
        $this->assertFalse($record->isSouthNode());
    }

    #[TestDox("can be a south node.")]
    public function test_is_south_node(): void
    {
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $datetime */
        $datetime = $this->getMockedSwissEphemerisDateTime();
        /** @var Angle&MockObject $angle */
        $angle = $this->createMock(Angle::class);
        $daily_speed = $this->createMock(DailySpeed::class);
        $record = new DraconicRecord($datetime, $angle, $angle, $daily_speed);
        $record->cardinality = Cardinality::South;
        // This checks that the property is immutable.
        $record->cardinality = Cardinality::North;

        // Act & Assert
        $this->assertTrue($record->isSouthNode());
        $this->assertFalse($record->isNorthNode());
    }    

    #[TestDox("can be casted to string.")]
    public function test_casting_to_string(): void
    {
        // Arrange
        $datetime = $this->getRandomSwissEphemerisDateTime();
        $moon_longitude = $this->randomLongitude();
        $opposite = Angle::createFromValues(180, direction: Rotation::CLOCKWISE);
        $north_node_longitude = $this->randomLongitude();
        $south_node_longitude = $north_node_longitude->absSum($opposite);
        $daily_speed = $this->getRandomMoonDailySpeed();
        $cardinality = self::$faker->randomElement(Cardinality::cases());
        $record = new DraconicRecord($datetime, $moon_longitude, $north_node_longitude, $daily_speed);
        $record->cardinality = $cardinality;
        $expected_cardinality = ((array) $cardinality)["name"];

        // Act & Assert
        $this->assertEquals(<<<TEXT
DraconicRecord
cardinality: $expected_cardinality
daily_speed: {$daily_speed}
moon_longitude: {$moon_longitude->toSexadecimalDegrees()}
north_node_longitude: {$north_node_longitude->toSexadecimalDegrees()}
south_node_longitude: {$south_node_longitude->toSexadecimalDegrees()}
timestamp: {$datetime->toDateTimeString()}

TEXT, (string) $record
        );
    }

    public function test_equals_method(): void
    {
        $this->testEqualComparison(4);
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
            new DraconicRecord(
                $property_couples[0][$first],
                $property_couples[1][$first],
                $property_couples[2][$first],
                $property_couples[3][$first]
            ),
            new DraconicRecord(
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
        $d1 = $this->getRandomSwissEphemerisDateTime();
        $d2 = $d1->clone()->addYear();
        $m1 = Angle::createFromValues(180);
        $m2 = Angle::createFromValues(90);
        $n1 = clone $m1;
        $n2 = clone $m2;
        $s1 = DailySpeed::createFromDecimal(12.0);
        $s2 = DailySpeed::createFromDecimal(13.0);
        return [
            0 => [
                self::DIFFERENT => [$d1, $d2],
                self::EQUAL     => [$d1, $d1]
            ],
            1 => [
                self::DIFFERENT => [$m1, $m2],
                self::EQUAL     => [$m1, $m1]
            ],
            2 => [
                self::DIFFERENT => [$n1, $n2],
                self::EQUAL     => [$n1, $n1]
            ],
            3 => [
                self::DIFFERENT => [$s1, $s2],
                self::EQUAL     => [$s1, $s1]
            ]
        ];
    }

}