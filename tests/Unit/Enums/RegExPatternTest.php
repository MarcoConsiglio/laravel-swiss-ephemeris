<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Enums;

use MarcoConsiglio\Ephemeris\Enums\RegExPattern;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithFailureMessage;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[TestDox("The RegExPattern enumeration")]
#[CoversClass(RegExPattern::class)]
class RegExPatternTest extends TestCase
{
    use WithFailureMessage;

    #[TestDox("have several regural expression to match portions of the Swiss Ephemeris output.")]
    public function test_regex_patterns()
    {
        // Arrange
        $cases = [
            [RegExPattern::RegExDelimiter."\d{1,2}\.\d{1,2}\.\d{1,4}j?[[:space:]]{1}\d{1,2}\:\d{2}\:\d{2}[[:space:]](?:(?:TT)|(?:UT)){1}".RegExPattern::RegExDelimiter, RegExPattern::UniversalAndTerrestrialDateTime],
            [RegExPattern::RegExDelimiter."(?<=\s)-?\d+\.\d+\b".RegExPattern::RegExDelimiter, RegExPattern::RelativeDecimalNumber],
            [RegExPattern::RegExDelimiter."(?:error)(.+)".RegExPattern::RegExDelimiter, RegExPattern::SwetestError]
        ];

        // Act & Assert
        foreach ($cases as $case) {
            $this->assertEquals($case[0], $case[1]->value, $this->enumFail($case[1]->name));
        }
    }
}