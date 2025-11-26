<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Records\Moon;

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
        $record = new DraconicRecord($datetime, $angle, $angle, $angle, 12.0);

        // Act & Assert
        $this->assertProperty("timestamp", $datetime, SwissEphemerisDateTime::class, $record->timestamp);
    }

    #[TestDox("has a \"moon_longitude\", \"node_longitude\", \"moon_latitude\" properties which are Angle(s).")]
    public function test_moon_longitude_property()
    {
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $datetime */
        $datetime = $this->getMocked(SwissEphemerisDateTime::class);
        $moon_longitude = Angle::createFromValues(180, 30, 15);
        $node_longitude = Angle::createFromValues(180, 15, 30);
        $moon_latitude = Angle::createFromValues(5, 20, 7);
        $record = new DraconicRecord($datetime, $moon_longitude, $moon_latitude, $node_longitude, 12.0);

        // Act & Assert
        $this->assertProperty("moon_longitude", $moon_longitude, Angle::class, $record->moon_longitude);
        $this->assertProperty("moon_latitude", $moon_latitude, Angle::class, $record->moon_latitude);
        $this->assertProperty("node_longitude", $node_longitude, Angle::class, $record->node_longitude);
    }

    public function test_daily_speed_property()
    {
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $datetime */
        $datetime = $this->getMocked(SwissEphemerisDateTime::class);
        /** @var Angle&MockObject $angle */
        $angle = $this->getMocked(Angle::class);
        $moon_daily_speed = 12.0;
        $record = new DraconicRecord($datetime, $angle, $angle, $angle, $moon_daily_speed);

        // Act & Assert
        $this->assertProperty("daily_speed", $moon_daily_speed, "float", $record->daily_speed);
    }

    #[TestDox("can be a north node.")]
    public function test_is_north_node()
    {
        $this->markTestSkipped("A better algorithm to decide weather the moon is passing toward the southern/northern emisphere is needed.");
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $datetime */
        $datetime = $this->getMocked(SwissEphemerisDateTime::class);
        /** @var Angle&MockObject $angle */
        $angle = $this->getMocked(Angle::class);
        $moon_latitude = Angle::createFromValues(7);
        $record = new DraconicRecord($datetime, $angle, $angle, $moon_latitude, 12.0);

        // Act & Assert
        $this->assertTrue($record->isNorthNode());
        $this->assertFalse($record->isSouthNode());
    }

    #[TestDox("can be a south node.")]
    public function test_is_south_node()
    {
        $this->markTestSkipped("A better algorithm to decide weather the moon is passing toward the southern/northern emisphere is needed.");
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $datetime */
        $datetime = $this->getMocked(SwissEphemerisDateTime::class);
        /** @var Angle&MockObject $angle */
        $angle = $this->getMocked(Angle::class);
        $moon_latitude = Angle::createFromValues(7, 0, 0.0, Angle::CLOCKWISE);
        $record = new DraconicRecord($datetime, $angle, $angle, $moon_latitude, 12.0);

        // Act & Assert
        $this->assertTrue($record->isSouthNode());
        $this->assertFalse($record->isNorthNode());
    }    
}