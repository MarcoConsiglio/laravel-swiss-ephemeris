<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Parsers\Strategies;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Parsers\Strategies\Error;
use MarcoConsiglio\Ephemeris\Parsers\Strategies\ParsingStrategy;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;

#[TestDox("The Error parsers")]
#[CoversClass(Error::class)]
class ErrorTest extends TestCase
{
    #[TestDox("matches errors in the raw ephemeris output.")]
    public function test_can_find_an_error()
    {
        // Arrange
        $expected_error = "Something went wrong.";
        $text_1 = "error $expected_error";
        $text_2 = "Ephemeris output";
        $text_3 = "";
        $strategy_1 = new Error($text_1);
        $strategy_2 = new Error($text_2);
        $strategy_3 = new Error($text_3);
        //      Guard Assertions
        $this->assertInstanceOf(ParsingStrategy::class, $strategy_1,
            $this->mustImplement(Error::class, ParsingStrategy::class)
        );

        // Act
        $error_found_1 = $strategy_1->found();
        $error_found_2 = $strategy_2->found();
        $error_found_3 = $strategy_3->found();

        // Assert
        $this->assertSame($expected_error, $error_found_1,
            "The expected error must be $expected_error but found $error_found_1."
        );
        $this->assertNull($error_found_2);
        $this->assertNull($error_found_3);
    }
}