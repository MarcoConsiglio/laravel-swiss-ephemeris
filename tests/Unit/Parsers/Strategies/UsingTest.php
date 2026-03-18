<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Parsers\Strategies;

use MarcoConsiglio\Ephemeris\Parsers\Strategies\Using;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[CoversClass(Using::class)]
#[TestDox("The Using parser")]
class UsingTest extends TestCase
{
    #[TestDox("matches using notice in the raw output.")]
    public function test_can_find_using_notice(): void
    {
        // Arrange
        $text_1 = "using Moshier eph.;";
        $text_2 = "Ephemeris output.";
        $text_3 = "";
        $strategy_1 = new Using($text_1);
        $strategy_2 = new Using($text_2);
        $strategy_3 = new Using($text_3);

        // Act
        $notice_found_1 = $strategy_1->found();
        $notice_found_2 = $strategy_2->found();
        $notice_found_3 = $strategy_3->found();

        // Assert
        $this->assertSame($text_1, $notice_found_1);
        $this->assertNull($notice_found_2);
        $this->assertNull($notice_found_3);
    }
}