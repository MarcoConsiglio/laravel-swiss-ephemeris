<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Enums;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use MarcoConsiglio\Ephemeris\Enums\RegExPattern;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithFailureMessage;

#[TestDox("The RegExPattern enumeration")]
#[CoversClass(RegExPattern::class)]
class RegExPatternTest extends TestCase
{
    use WithFailureMessage;

    #[TestDox("can produce a regular expression to match ephemeris object names.")]
    public function test_get_object_name_regex(): void
    {
        // Arrange
        $expected_regex = '/(Moon)/';
        
        // Act
        $actual_regex = RegExPattern::getRegex(RegExPattern::Moon);

        // Assert
        $this->assertEquals($expected_regex, $actual_regex);
    }
}