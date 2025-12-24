<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Parsers\Strategies;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Parsers\Strategies\Warning;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;

#[CoversClass(Warning::class)]
#[TestDox("The Warning parser")]
class WarningTest extends TestCase
{
    #[TestDox("matches warnings in the raw output.")]
    public function test_can_find_a_warning(): void
    {
        // Arrange
        $warning = "warning:";
        $text_1 = <<<HERE
 SwissEph file 'sepl_18.se1' not found in PATH '.;/my/path/laravel/resources/swiss_ephemeris;.:/users/ephe2/:/users/ephe/'
HERE;
        $text_2 = "Ephemeris output.";
        $text_3 = "";
        $strategy_1 = new Warning($warning.$text_1);
        $strategy_2 = new Warning($text_2);
        $strategy_3 = new Warning($text_3);
        
        // Act
        $warning_found_1 = $strategy_1->found();
        $warning_found_2 = $strategy_2->found();
        $warning_found_3 = $strategy_3->found();

        // Assert
        $this->assertSame(trim($text_1), $warning_found_1);
        $this->assertNull($warning_found_2);
        $this->assertNull($warning_found_3);
    }
}