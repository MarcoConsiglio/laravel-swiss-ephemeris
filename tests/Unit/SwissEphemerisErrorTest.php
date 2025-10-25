<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit;

use MarcoConsiglio\Ephemeris\Exceptions\SwissEphemerisError;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[CoversClass(SwissEphemerisError::class)]
#[TestDox("The SwissEphemerisError")]
class SwissEphemerisErrorTest extends TestCase
{
    #[TestDox("list all errors thrown by the swetest executable.")]
    public function test_multiple_errors()
    {
        // Arrange
        $error_message_A = fake()->sentence;
        $error_message_B = fake()->sentence;
        
        // Act
        $error_1 = new SwissEphemerisError([$error_message_A, $error_message_B]);
        $error_2 = new SwissEphemerisError([$error_message_A]);
        $error_3 = new SwissEphemerisError([]);
        $actual_error_message_1 = $error_1->getMessage();
        $actual_error_message_2 = $error_2->getMessage();
        $actual_error_message_3 = $error_3->getMessage();

        // Assert
        $this->assertStringContainsString($error_message_A, $actual_error_message_1);
        $this->assertStringContainsString($error_message_B, $actual_error_message_1);
        $this->assertStringContainsString($error_message_A, $actual_error_message_2);
        $this->assertEmpty($actual_error_message_3);
    }

    #[TestDox("removes duplicate error messages.")]
    public function test_multiple_errors_with_duplicates()
    {
        // Arrange
        $error_message_A = fake()->sentence;
        $error_message_B = fake()->sentence;
        $error_message_C = $error_message_A;
        
        // Act
        $error = new SwissEphemerisError([$error_message_A, $error_message_B, $error_message_C]);
        $actual_error_message = $error->getMessage();

        // Assert
        $message_A_count = substr_count($actual_error_message, $error_message_A);
        $this->assertStringContainsString($error_message_A, $actual_error_message);
        $this->assertStringContainsString($error_message_B, $actual_error_message);
        $this->assertEquals(1, $message_A_count);
    }

    // #[TestDox("accepts only strings errors")]
    // public function test_accepts_only_string_errors()
    // {
    //     // Arrange
    //     $error_message_A = fake()->sentence;
    //     $error_message_B = fake()->sentence;
    //     $error_message_C = $error_message_A;
    //     $error_message_D = fake()->randomNumber(5);
        
    //     // Act
    //     $error = new SwissEphemerisError([$error_message_A, $error_message_B, $error_message_C, $error_message_D]);
    //     $actual_error_message = $error->getMessage();

    //     // Assert
    //     $message_A_count = substr_count($actual_error_message, $error_message_A);
    //     $this->assertStringContainsString($error_message_A, $actual_error_message);
    //     $this->assertStringContainsString($error_message_B, $actual_error_message);
    //     $this->assertEquals(1, $message_A_count);
    // }

}