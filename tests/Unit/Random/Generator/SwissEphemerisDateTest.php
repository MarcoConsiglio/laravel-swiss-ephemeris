<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Random\Generator;

use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Random\Generator\SwissEphemerisDate as SwissEphemerisDateGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\SwissEphemerisDateRange;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\SwissEphemerisDate as SwissEphemerisDateValidator;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(SwissEphemerisDateGenerator::class)]
class SwissEphemerisDateTest extends TestCase
{
    public function test_random_generation(): void
    {
        // Arrange
        $validator = $this->createMock(SwissEphemerisDateValidator::class);
        $validator->expects($this->once())->method('validate');
        $range = new SwissEphemerisDateRange(
            SwissEphemerisDateRange::MIN,
            SwissEphemerisDateRange::MAX
        );
        $generator = new SwissEphemerisDateGenerator(
            self::$faker, $validator, $range
        );

        // Act
        $date = $generator->generate();

        // Assert
        $this->assertInstanceOf(SwissEphemerisDateTime::class, $date);
    }
}