<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Records\Moon;

use MarcoConsiglio\Ephemeris\Records\Moon\AnomalisticRecord;
use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Goniometry\Angle;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;

#[TestDox("The AnomalisticRecord")]
#[CoversClass(AnomalisticRecord::class)]
#[UsesClass(ApogeeRecord::class)]
#[UsesClass(PerigeeRecord::class)]
#[UsesClass(Angle::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
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
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->angle = $this->getMocked(Angle::class);
        $this->date = $this->getMocked(SwissEphemerisDateTime::class);
    }

    #[TestDox("can be an ApogeeRecord.")]
    public function test_can_be_an_apogee()
    {
        // Arrange
        $record = new ApogeeRecord($this->date, $this->angle, $this->angle);

        // Act & Assert
        $this->assertTrue($record->isApogee());
        $this->assertFalse($record->isPerigee());
    }

    #[TestDox("can be a PerigeeRecord.")]
    public function test_can_be_a_perigee()
    {
        // Arrange
        $record = new PerigeeRecord($this->date, $this->angle, $this->angle);

        // Act & Assert
        $this->assertTrue($record->isPerigee());
        $this->assertFalse($record->isApogee());
    }
}