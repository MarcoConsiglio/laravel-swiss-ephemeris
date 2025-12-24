<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Parsers\Strategies;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Parsers\Strategies\EmptyLine;
use MarcoConsiglio\Ephemeris\Parsers\Strategies\ParsingStrategy;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;

#[CoversClass(EmptyLine::class)]
#[TestDox("The EmptyLine parser")]
class EmptyLineTest extends TestCase
{
    #[TestDox("matches an empty line in the raw ephemeris.")]
    public function test_can_find_an_empty_line(): void
    {
        // Arrange
        $empty_line_1 = "";
        $empty_line_2 = "Ephemeris output.";
        $empty_line_parser_1 = new EmptyLine($empty_line_1);
        $empty_line_parser_2 = new EmptyLine($empty_line_2);
        //      Guard Assertions
        $this->assertInstanceOf(ParsingStrategy::class, $empty_line_parser_1,
            $this->mustImplement(EmptyLine::class, ParsingStrategy::class)
        );

        // Act
        $empty_line_found_1 = $empty_line_parser_1->found();
        $empty_line_found_2 = $empty_line_parser_2->found();

        // Assert
        $this->assertTrue($empty_line_found_1);
        $this->assertFalse($empty_line_found_2);
    }
}