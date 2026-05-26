<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Random\Generator;

use MarcoConsiglio\BCMathExtended\Range;
use MarcoConsiglio\Ephemeris\Tests\Random\Generator\AngularDistanceOutsideNeighbourhood as AngularDistanceOutsideNeighbourhoodGenerator;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\AngularDistanceOutsideNeighbourhood as AngularDistanceOutsideNeighbourhoodValidator;
use MarcoConsiglio\Ephemeris\Tests\Unit\Random\Generator\TestCase as GeneratorTestCase;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Random\AngularDistanceRange;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(AngularDistanceOutsideNeighbourhoodGenerator::class)]
class AngularDistanceOutsideNeighbourhoodTest extends GeneratorTestCase
{
    public function test_random_generation(): void
    {
        /**
         * Relative extremes
         * Faker return boolean true
         */
        // Arrange
        $validator = new AngularDistanceOutsideNeighbourhoodValidator(
            $center = AngularDistance::createFromValues(0),
            $delta = Angle::createFromValues(2)
        );
        $generator = new AngularDistanceOutsideNeighbourhoodGenerator(
            $this->trickFakerToGetTrueOut(), $validator, new AngularDistanceRange(0, 0)
        );

        // Act
        $angle = $generator->generate();

        // Assert
        $this->assertInstanceOf(AngularDistance::class, $angle);
        $this->assertTrue(
            $angle->toSexadecimalDegrees()->value->inRangeMinExcluded(
                new Range(+1, AngularDistanceRange::max())
            ),
            "Center value: {$center}\nDelta: {$delta}\nRandom angle: {$angle}.\n"
        );

        /**
         * Relative extremes
         * Faker return boolean false
         */
        // Arrange
        $validator = new AngularDistanceOutsideNeighbourhoodValidator(
            $center = AngularDistance::createFromValues(0),
            $delta = Angle::createFromValues(2)
        );
        $generator = new AngularDistanceOutsideNeighbourhoodGenerator(
            $this->trickFakerToGetFalseOut(), $validator, new AngularDistanceRange(0, 0)
        );

        // Act
        $angle = $generator->generate();

        // Assert
        $this->assertInstanceOf(AngularDistance::class, $angle);
        $this->assertTrue(
            $angle->toSexadecimalDegrees()->value->inRangeMaxExcluded(
                new Range(AngularDistanceRange::min(), -1)
            ), "Center value: {$center}\nDelta: {$delta}\nRandom angle: {$angle}.\n"
        );

        /**
         * Positive extremes
         * Faker return boolean true
         */
        // Arrange
        $validator = new AngularDistanceOutsideNeighbourhoodValidator(
            $center = AngularDistance::createFromValues(90),
            $delta = Angle::createFromValues(2)
        );
        $generator = new AngularDistanceOutsideNeighbourhoodGenerator(
            $this->trickFakerToGetTrueOut(), $validator, new AngularDistanceRange(0, 0)
        );

        // Act
        $angle = $generator->generate();

        // Assert
        $this->assertInstanceOf(AngularDistance::class, $angle);
        $this->assertTrue(
            $angle->toSexadecimalDegrees()->value->inRangeMaxExcluded(
                new Range(AngularDistanceRange::min(), 89)
            ), "Center value: {$center}\nDelta: {$delta}\nRandom angle: {$angle}.\n"
        );

        /**
         * Positive extremes
         * Faker return boolean false
         */
        // Arrange
        $validator = new AngularDistanceOutsideNeighbourhoodValidator(
            $center = AngularDistance::createFromValues(90),
            $delta = Angle::createFromValues(2)
        );
        $generator = new AngularDistanceOutsideNeighbourhoodGenerator(
            $this->trickFakerToGetFalseOut(), $validator, new AngularDistanceRange(0, 0)
        );

        // Act
        $angle = $generator->generate();

        // Assert
        $this->assertInstanceOf(AngularDistance::class, $angle);
        $this->assertTrue(
            $angle->toSexadecimalDegrees()->value->inRangeMinExcluded(
                new Range(91, AngularDistanceRange::max())
            ), "Center value: {$center}\nDelta: {$delta}\nRandom angle: {$angle}.\n"
        );

        //---

        /**
         * Negative extremes
         * Faker return boolean true
         */
        // Arrange
        $validator = new AngularDistanceOutsideNeighbourhoodValidator(
            $center = AngularDistance::createFromDecimal(-90),
            $delta = Angle::createFromValues(2)
        );
        $generator = new AngularDistanceOutsideNeighbourhoodGenerator(
            $this->trickFakerToGetTrueOut(), $validator, new AngularDistanceRange(0, 0)
        );

        // Act
        $angle = $generator->generate();

        // Assert
        $this->assertInstanceOf(AngularDistance::class, $angle);
        $this->assertTrue(
            $angle->toSexadecimalDegrees()->value->inRangeMaxExcluded(
                new Range(AngularDistanceRange::min(), -89)
            ), "Center value: {$center}\nDelta: {$delta}\nRandom angle: {$angle}.\n"
        );

        /**
         * Negative extremes
         * Faker return boolean false
         */
        // Arrange
        $validator = new AngularDistanceOutsideNeighbourhoodValidator(
            $center = AngularDistance::createFromDecimal(-90),
            $delta = Angle::createFromValues(2)
        );
        $generator = new AngularDistanceOutsideNeighbourhoodGenerator(
            $this->trickFakerToGetFalseOut(), $validator, new AngularDistanceRange(0, 0)
        );

        // Act
        $angle = $generator->generate();

        // Assert
        $this->assertInstanceOf(AngularDistance::class, $angle);
        $this->assertTrue(
            $angle->toSexadecimalDegrees()->value->inRangeMinExcluded(
                new Range(-91, AngularDistanceRange::max())
            ), "Center value: {$center}\nDelta: {$delta}\nRandom angle: {$angle}.\n"
        );
    }
}