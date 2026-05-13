<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Random\Validator;

use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase as UnitTestCase;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Interfaces\Angle as AngleInterface;

abstract class TestCase extends UnitTestCase
{
    protected function testValidator(
        int|float $actual_min,
        int|float $actual_max,
        int|float $expected_min,
        int|float $expected_max
    ): void {
        // Arrange
        $validator_class = $this->getValidatorClass();
        $validator = new $validator_class($actual_min, $actual_max);

        // Act
        $validator->validate($actual_min, $actual_max);

        // Assert
        // Assert
        $this->assertEquals($expected_min, $actual_min);
        $this->assertEquals($expected_max, $actual_max);
    }

    protected function testNeighbourhoodValidator(
        AngleInterface $center, 
        Angle $delta, 
        int|float $expected_min, 
        int|float $expected_max
    ): void {
        // Arrange
        $validator_class = $this->getValidatorClass();
        $validator = new $validator_class($center, $delta);
        $min = 0;
        $max = 0;

        // Act
        $validator->validate($min, $max);

        // Assert
        $this->assertEquals($expected_min, $min);
        $this->assertEquals($expected_max, $max);
    }

    abstract protected function getValidatorClass(): string;
}