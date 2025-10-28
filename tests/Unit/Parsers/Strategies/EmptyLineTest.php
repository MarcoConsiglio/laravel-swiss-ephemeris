<?php
namespace MarcoConsiglio\Ephemeris\Parsers\Strategies;

use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[CoversClass(EmptyLine::class)]
#[TestDox("The EmptyLine parser")]
class EmptyLineTest extends TestCase
{
    #[TestDox("matches an empty line in the raw ephemeris.")]
    public function test_can_find_an_empty_line()
    {
        // Arrange
        $empty_line_1 = "";
        $empty_line_2 = "Ephemeris output.";
        $empty_line_parser_1 = new EmptyLine($empty_line_1);
        $empty_line_parser_2 = new EmptyLine($empty_line_2);

        // Act
        $empty_line_found_1 = $empty_line_parser_1->found();
        $empty_line_found_2 = $empty_line_parser_2->found();

        // Assert
        $this->assertTrue($empty_line_found_1);
        $this->assertFalse($empty_line_found_2);
    }
}