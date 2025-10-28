<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Parsers\Strategies;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Parsers\Strategies\Warning;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;

#[TestDox("The Warning parser")]
#[CoversClass(Warning::class)]
class WarningTest extends TestCase
{
    #[TestDox("matches warnings in the raw output.")]
    public function test_can_find_a_warning()
    {
        // Arrange
        $warning = "warning:";
        $warning_text = <<<HERE
 SwissEph file 'sepl_18.se1' not found in PATH '.;/my/path/laravel/resources/swiss_ephemeris;.:/users/ephe2/:/users/ephe/' 
using Moshier eph.; "
HERE;
        $non_worning = "Ephemeris output.";
        $strategy_1 = new Warning($warning.$warning_text);
        $strategy_2 = new Warning($non_worning);
        
        // Act
        $warning_found_1 = $strategy_1->found();
        $warning_found_2 = $strategy_2->found();

        // Assert
        $this->assertSame(trim($warning_text), $warning_found_1);
        $this->assertNull($warning_found_2);
    }
}