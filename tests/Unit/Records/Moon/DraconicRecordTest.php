<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Records\Moon;

use MarcoConsiglio\Ephemeris\Enums\Cardinality;
use MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Goniometry\Angle;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;

#[CoversClass(DraconicRecord::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
#[TestDox("The Moon\DraconicRecord")]
class DraconicRecordTest extends TestCase
{
    #[TestDox("has a \"timestamp\" property which is a SwissEphemerisDateTime.")]
    public function test_timestamp_proerty()
    {
        // Arrange
        $datetime = SwissEphemerisDateTime::create(2000);
        /** @var Angle&MockObject $angle */
        $angle = $this->getMocked(Angle::class);
        $record = new DraconicRecord($datetime, $angle, $angle, 12.0, true);

        // Act & Assert
        $this->assertProperty("timestamp", $datetime, SwissEphemerisDateTime::class, $record->timestamp);
    }

    #[TestDox("has a \"moon_longitude\", \"north_node_longitude\", \"south_node_longitude\", properties which are Angle(s).")]
    public function test_moon_longitude_property()
    {
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $datetime */
        $datetime = $this->getMockedSwissEphemerisDateTime();
        $moon_longitude = Angle::createFromValues(180, 30, 15);
        $north_node_longitude = Angle::createFromValues(180, 15, 30);
        $opposite = Angle::createFromValues(180, direction: Angle::CLOCKWISE);
        $south_node_longitude = Angle::sum($north_node_longitude, $opposite);
        $record = new DraconicRecord($datetime, $moon_longitude, $north_node_longitude, 12.0, true);

        // Act & Assert
        $this->assertProperty("moon_longitude", $moon_longitude, Angle::class, $record->moon_longitude);
        $this->assertProperty("north_node_longitude", $north_node_longitude, Angle::class, $record->north_node_longitude);
        $this->assertProperty("south_node_longitude", $south_node_longitude, Angle::class, $record->south_node_longitude);
    }

    #[TestDox("has a \"daily_speed\" property which is a float.")]
    public function test_daily_speed_property()
    {
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $datetime */
        $datetime = $this->getMockedSwissEphemerisDateTime();
        /** @var Angle&MockObject $angle */
        $angle = $this->getMocked(Angle::class);
        $moon_daily_speed = 12.0;
        $record = new DraconicRecord($datetime, $angle, $angle, $moon_daily_speed, 12.0, true);

        // Act & Assert
        $this->assertProperty("daily_speed", $moon_daily_speed, "float", $record->daily_speed);
    }

    #[TestDox("has a \"cardinality\" property which is a Cardinality enumeration.")]
    public function test_cardinality_speed_property()
    {
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $datetime */
        $datetime = $this->getMockedSwissEphemerisDateTime();
        /** @var Angle&MockObject $angle */
        $angle = $this->getMocked(Angle::class);
        $moon_daily_speed = 12.0;
        $north_record = new DraconicRecord($datetime, $angle, $angle, $moon_daily_speed, 12.0, true);
        $south_record = new DraconicRecord($datetime, $angle, $angle, $moon_daily_speed, 12.0, true);
        $north_record->cardinality = Cardinality::North;
        $south_record->cardinality = Cardinality::South;

        // Act & Assert
        $this->assertProperty("cardinality", Cardinality::North, Cardinality::class, $north_record->cardinality);
        $this->assertProperty("cardinality", Cardinality::South, Cardinality::class, $south_record->cardinality);
    }

    #[TestDox("can be a north node.")]
    public function test_is_north_node()
    {
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $datetime */
        $datetime = $this->getMockedSwissEphemerisDateTime();
        /** @var Angle&MockObject $angle */
        $angle = $this->getMocked(Angle::class);
        $record = new DraconicRecord($datetime, $angle, $angle, 12.0, true);
        $record->cardinality = Cardinality::North;
        // This checks that the property is immutable.
        $record->cardinality = Cardinality::South;

        // Act & Assert
        $this->assertTrue($record->isNorthNode());
        $this->assertFalse($record->isSouthNode());
    }

    #[TestDox("can be a south node.")]
    public function test_is_south_node()
    {
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $datetime */
        $datetime = $this->getMockedSwissEphemerisDateTime();
        /** @var Angle&MockObject $angle */
        $angle = $this->getMocked(Angle::class);
        $record = new DraconicRecord($datetime, $angle, $angle, 12.0, true);
        $record->cardinality = Cardinality::South;
        // This checks that the property is immutable.
        $record->cardinality = Cardinality::North;

        // Act & Assert
        $this->assertTrue($record->isSouthNode());
        $this->assertFalse($record->isNorthNode());
    }    
}