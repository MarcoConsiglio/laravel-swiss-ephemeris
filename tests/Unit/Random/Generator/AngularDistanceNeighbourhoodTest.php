<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Random\Generator;

use MarcoConsiglio\Ephemeris\Tests\Random\Generator\AngularDistanceNeighbourhood as AngularDistanceNeighbourhoodGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\AngularDistanceNeighbourhood as AngularDistanceNeighbourhoodValidator;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(AngularDistanceNeighbourhoodGenerator::class)]
class AngularDistanceNeighbourhoodTest extends TestCase
{
    public function test_random_generation(): void
    {
        // Arrange
        $validator = $this->createMock(AngularDistanceNeighbourhoodValidator::class);
        $validator->expects($this->once())->method('validate');
        $range = new AngularDistanceRange(0, 0); // Any range is meaningless.
        $generator = new AngularDistanceNeighbourhoodGenerator(
            self::$faker, $validator, $range
        );

        // Act
        $angle = $generator->generate();

        // Assert
        $this->assertInstanceOf(AngularDistance::class, $angle);
    }
}