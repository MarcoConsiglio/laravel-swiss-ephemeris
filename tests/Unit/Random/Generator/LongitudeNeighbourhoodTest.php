<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Random\Generator;

use MarcoConsiglio\Ephemeris\Tests\Random\Generator\LongitudeNeighbourhood as LongitudeNeighbourhoodGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\LongitudeRange;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\LongitudeNeighbourhood as LongitudeNeighbourhoodValidator;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Goniometry\Angle;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(LongitudeNeighbourhoodGenerator::class)]
class LongitudeNeighbourhoodTest extends TestCase
{
    public function test_random_generation(): void
    {
        // Arrange
        $validator = $this->createMock(LongitudeNeighbourhoodValidator::class);
        $validator->expects($this->once())->method('validate');
        $range = new LongitudeRange(0, 0); // Any range is meaningless.
        $generator = new LongitudeNeighbourhoodGenerator(
            self::$faker, $validator, $range
        );

        // Act
        $longitude = $generator->generate();

        // Assert
        $this->assertInstanceOf(Angle::class, $longitude);
    }
}