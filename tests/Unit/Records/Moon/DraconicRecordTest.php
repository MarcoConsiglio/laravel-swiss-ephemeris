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
        $datetime = SwissEphemerisDateTime::create(2000, 12, 3);
        /** @var Angle&MockObject $angle */
        $angle = $this->getMocked(Angle::class);
        $record = new DraconicRecord($datetime, $angle, $angle, $angle);

        // Act & Assert
        $this->assertSame($datetime, $record->timestamp);
    }

    #[TestDox("has a \"moon_longitude\" property which is an Angle.")]
    public function test_moon_longitude_property()
    {
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $datetime */
        $datetime = $this->getMocked(SwissEphemerisDateTime::class);
        /** @var Angle&MockObject $angle */
        $angle = $this->getMocked(Angle::class);
        $moon_longitude = Angle::createFromValues(180, 30, 15);
        $record = new DraconicRecord($datetime, $moon_longitude, $angle, $angle);

        // Act & Assert
        $this->assertSame($moon_longitude, $record->moon_longitude);
    }

    #[TestDox("has a \"node_longitude\" property which is an Angle.")]
    public function test_node_longitude_property()
    {
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $datetime */
        $datetime = $this->getMocked(SwissEphemerisDateTime::class);
        /** @var Angle&MockObject $angle */
        $angle = $this->getMocked(Angle::class);
        $node_longitude = Angle::createFromValues(180, 30, 15);
        $record = new DraconicRecord($datetime, $angle, $angle, $node_longitude);

        // Act & Assert
        $this->assertSame($node_longitude, $record->node_longitude);
    }

    #[TestDox("has a \"moon_latitude\" property which is an Angle.")]
    public function test_moon_latitude_property()
    {
        // Arrange
        /** @var SwissEphemerisDateTime&MockObject $datetime */
        $datetime = $this->getMocked(SwissEphemerisDateTime::class);
        /** @var Angle&MockObject $angle */
        $angle = $this->getMocked(Angle::class);
        $moon_latitude = Angle::createFromValues(180, 30, 15);
        $record = new DraconicRecord($datetime, $angle, $moon_latitude, $angle);

        // Act & Assert
        $this->assertSame($moon_latitude, $record->moon_latitude);
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
        $record = new DraconicRecord($datetime, $angle, $angle, $moon_latitude);

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
        $record = new DraconicRecord($datetime, $angle, $angle, $moon_latitude);

        // Act & Assert
        $this->assertTrue($record->isSouthNode());
        $this->assertFalse($record->isNorthNode());
    }    
}