<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Random\Generator;

use MarcoConsiglio\Ephemeris\Tests\Random\Generator\Longitude as LongitudeGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\LongitudeRange;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\Longitude as LongitudeValidator;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Goniometry\Angle;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(LongitudeGenerator::class)]
class LongitudeTest extends TestCase
{
    public function test_random_generation(): void
    {
        // Arrange
        $validator = $this->createMock(LongitudeValidator::class);
        $validator->expects($this->once())->method('validate');
        $range = new LongitudeRange(
            LongitudeRange::min(),
            LongitudeRange::max()
        );
        $generator = new LongitudeGenerator(
            self::$faker, $validator, $range
        );

        // Act
        $longitude = $generator->generate();

        // Assert
        $this->assertInstanceOf(Angle::class, $longitude);
    }
}