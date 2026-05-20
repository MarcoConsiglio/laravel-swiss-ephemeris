<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Records\Moon;

use MarcoConsiglio\Ephemeris\Records\DailySpeed;
use MarcoConsiglio\Goniometry\Angle;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\Records\Moon\AnomalisticRecord;
use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;

#[TestDox("The Moon AnomalisticRecord")]
#[CoversClass(AnomalisticRecord::class)]
class AnomalisticRecordTest extends TestCase
{
    /**
     * The mocked Angle to be used in the tests.
     * @var Angle&MockObject
     */
    protected Angle&MockObject $angle;

    /**
     * The mocked SwissEphemerisDateTime to be used in the tests.
     * @var SwissEphemerisDateTime&MockObject
     */
    protected SwissEphemerisDateTime&MockObject $date;

    /**
     * The mocked DailySpeed to be used in the tests.
     */
    protected DailySpeed&MockObject $daily_speed;

    /**
     * Setup the test environment.
     */
    #[\Override]
    public function setUp(): void
    {
        parent::setUp();
        $this->angle = $this->getMocked(Angle::class);
        $this->date = $this->getMockedSwissEphemerisDateTime();
        $this->daily_speed = $this->createMock(DailySpeed::class);
    }

    #[TestDox("can be an ApogeeRecord.")]
    public function test_can_be_an_apogee(): void
    {
        // Arrange
        $record = new ApogeeRecord($this->date, $this->angle, $this->angle, $this->daily_speed);

        // Act & Assert
        $this->assertTrue($record->isApogee());
        $this->assertFalse($record->isPerigee());
    }

    #[TestDox("can be a PerigeeRecord.")]
    public function test_can_be_a_perigee(): void
    {
        // Arrange
        $record = new PerigeeRecord($this->date, $this->angle, $this->angle, $this->daily_speed);

        // Act & Assert
        $this->assertTrue($record->isPerigee());
        $this->assertFalse($record->isApogee());
    }
}