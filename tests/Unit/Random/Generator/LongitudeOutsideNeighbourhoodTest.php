<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Random\Generator;

use MarcoConsiglio\BCMathExtended\Range;
use MarcoConsiglio\Ephemeris\Tests\Random\Generator\LongitudeOutsideNeighbourhood as LongitudeOutsideNeighbourhoodGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\LongitudeRange;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\AngularDelta as AngularDeltaValidator;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\LongitudeNeighbourhood as LongitudeNeighbourhoodValidator;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\LongitudeOutsideNeighbourhood as LongitudeOutsideNeighbourhoodValidator;
use MarcoConsiglio\Ephemeris\Tests\Unit\Random\Generator\TestCase as GeneratorTestCase;
use MarcoConsiglio\Goniometry\Angle;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(LongitudeOutsideNeighbourhoodGenerator::class)]
#[UsesClass(AngularDeltaValidator::class)]
#[UsesClass(LongitudeNeighbourhoodValidator::class)]
#[UsesClass(LongitudeOutsideNeighbourhoodValidator::class)]
class LongitudeOutsideNeighbourhoodTest extends GeneratorTestCase
{
    public function test_random_generation(): void
    {
        /**
         * $min ≤ $max
         * Faker return boolean true
         */
        // Arrange
        $validator = new LongitudeOutsideNeighbourhoodValidator(
            Angle::createFromValues(180),
            Angle::createFromValues(60)
        );
        $generator = new LongitudeOutsideNeighbourhoodGenerator(
            $this->trickFakerToGetTrueOut(),
            $validator,
            new LongitudeRange(0, 0)
        );

        // Act
        $longitude = $generator->generate();

        // Assert
        $this->assertInstanceOf(Angle::class, $longitude);
        $this->assertTrue(
            $longitude->toSexadecimalDegrees()->value->inRangeMaxExcluded(
                new Range(0, 150)
            )
        );

        /**
         * $min ≤ $max
         * Faker return boolean false
         */
        // Arrange
        $validator = new LongitudeOutsideNeighbourhoodValidator(
            Angle::createFromValues(180),
            Angle::createFromValues(60)
        );
        $generator = new LongitudeOutsideNeighbourhoodGenerator(
            $this->trickFakerToGetFalseOut(),
            $validator,
            new LongitudeRange(0, 0)
        );

        // Act
        $longitude = $generator->generate();

        // Assert
        $this->assertInstanceOf(Angle::class, $longitude);
        $this->assertTrue(
            $longitude->toSexadecimalDegrees()->value->inRangeExtremesExcluded(
                new Range(210, 360)
            )
        );

        /**
         * $min > $max
         */
        // Arrange
        $validator = new LongitudeOutsideNeighbourhoodValidator(
            Angle::createFromValues(0),
            Angle::createFromValues(60)
        );
        $generator = new LongitudeOutsideNeighbourhoodGenerator(
            self::$faker,
            $validator,
            new LongitudeRange(0, 0)
        );

        // Act
        $longitude = $generator->generate();

        // Assert
        $this->assertInstanceOf(Angle::class, $longitude);
        $this->assertTrue(
            $longitude->toSexadecimalDegrees()->value->inRangeExtremesExcluded(
                new Range(30, 360)
            )
        );
    }
}