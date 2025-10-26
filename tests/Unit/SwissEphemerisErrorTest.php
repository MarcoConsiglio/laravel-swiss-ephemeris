<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit;

use MarcoConsiglio\Ephemeris\Exceptions\SwissEphemerisError;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\MockBuilder;
use ReflectionClass;

#[CoversClass(SwissEphemerisError::class)]
#[TestDox("The SwissEphemerisError")]
class SwissEphemerisErrorTest extends TestCase
{
    #[TestDox("list all errors thrown by the swetest executable.")]
    public function test_multiple_errors()
    {
        // Arrange
        $error_message_A = $this->faker->sentence;
        $error_message_B = $this->faker->sentence;
        
        // Act
        $error_1 = new SwissEphemerisError([$error_message_A, $error_message_B, $error_message_B]);
        $actual_error_message_1 = $error_1->getMessage();
        
        // Assert
        $this->assertEquals("$error_message_A\n$error_message_B", $actual_error_message_1);
    }
}