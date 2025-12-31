<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Records\Moon;

use MarcoConsiglio\Ephemeris\Enums\Cardinality;
use MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithRecordsComparison;
use MarcoConsiglio\Goniometry\Angle;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;

#[CoversClass(DraconicRecord::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
#[TestDox("The Moon DraconicRecord")]
class DraconicRecordTest extends TestCase
{
    use WithRecordsComparison;

    #[TestDox("has a \"timestamp\" property which is a SwissEphemerisDateTime.")]
    public function test_timestamp_property(): void
    {
        // Arrange
        $datetime = $this->getRandomSwissEphemerisDateTime();
        /** @var Angle&MockObject $angle */
        $angle = $this->getMocked(Angle::class);
        $record = new DraconicRecord($datetime, $angle, $angle, 12.0);

        // Act & Assert
        $this->assertProperty("timestamp", $datetime, SwissEphemerisDateTime::class, $record->timestamp);
    }

    #[TestDox("has a \"moon_longitude\", \"north_node_longitude\", \"south_node_longitude\", properties which are Angle(s).")]
    public function test_moon_longitude_property(): void
    {
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $datetime */
        $datetime = $this->getMockedSwissEphemerisDateTime();
        $moon_longitude = $this->getSpecificAngle(180);
        $north_node_longitude = $this->getSpecificAngle(180);
        $opposite = Angle::createFromValues(180, direction: Angle::CLOCKWISE);
        $south_node_longitude = Angle::sum($north_node_longitude, $opposite);
        $record = new DraconicRecord($datetime, $moon_longitude, $north_node_longitude, 12.0);

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
        $angle = $this->getMocked(Angle::class);
        $moon_daily_speed = $this->getRandomMoonDailySpeed();
        $record = new DraconicRecord($datetime, $angle, $angle, $moon_daily_speed);

        // Act & Assert
        $this->assertProperty("daily_speed", $moon_daily_speed, "float", $record->daily_speed);
    }

    #[TestDox("has a \"cardinality\" property which is a Cardinality enumeration.")]
    public function test_cardinality_speed_property(): void
    {
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $datetime */
        $datetime = $this->getMockedSwissEphemerisDateTime();
        /** @var Angle&MockObject $angle */
        $angle = $this->getMocked(Angle::class);
        $moon_daily_speed = 12.0;
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
        $angle = $this->getMocked(Angle::class);
        $record = new DraconicRecord($datetime, $angle, $angle, 12.0);
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
        $angle = $this->getMocked(Angle::class);
        $record = new DraconicRecord($datetime, $angle, $angle, 12.0);
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
        $moon_longitude = $this->getRandomPositiveAngle();
        $opposite = $this->getSpecificAngle(-180);
        $north_node_longitude = $this->getRandomPositiveAngle();
        $south_node_longitude = Angle::absSum($north_node_longitude, $opposite);
        $daily_speed = $this->getRandomMoonDailySpeed();
        $cardinality = $this->faker->randomElement(Cardinality::cases());
        $record = new DraconicRecord($datetime, $moon_longitude, $north_node_longitude, $daily_speed);
        $record->cardinality = $cardinality;
        $expected_cardinality = ((array) $cardinality)["name"];

        // Act & Assert
        $this->assertEquals(<<<TEXT
DraconicRecord
cardinality: $expected_cardinality
daily_speed: {$daily_speed}°/day
moon_longitude: {$moon_longitude->toDecimal()}°
north_node_longitude: {$north_node_longitude->toDecimal()}°
south_node_longitude: {$south_node_longitude->toDecimal()}°
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
        $m1 = $this->getSpecificAngle(180.0);
        $m2 = $this->getSpecificAngle(90.0);
        $n1 = clone $m1;
        $n2 = clone $m2;
        $s1 = 12.0;
        $s2 = 13.0;
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