<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Random\Generator;

use MarcoConsiglio\Ephemeris\Tests\Random\Generator\Latitude as LatitudeGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\LatitudeRange;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\Latitude as LatitudeValidator;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Goniometry\Angle;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(LatitudeGenerator::class)]
#[CoversClass(LatitudeRange::class)]
class LatitudeTest extends TestCase
{
    public function test_random_generation(): void
    {
        // Arrange
        $validator = $this->createMock(LatitudeValidator::class);
        $validator->expects($this->once())->method('validate');
        $range = new LatitudeRange(
            LatitudeRange::min(), 
            LatitudeRange::max()
        );
        $generator = new LatitudeGenerator(
            self::$faker, $validator, $range
        );

        // Act
        $latitude = $generator->generate();

        // Assert
        $this->assertInstanceOf(Angle::class, $latitude);
    }
}