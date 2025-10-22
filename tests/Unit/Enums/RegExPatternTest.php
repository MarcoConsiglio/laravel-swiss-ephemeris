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

    #[TestDox("has several regular expression to match portions of the Swiss Ephemeris output.")]
    public function test_regex_patterns()
    {
        // Arrange
        $delimiter = '/';
        $cases = [[
            // Expected
            $delimiter
            ."\d{1,2}\.\d{1,2}\.\d{1,4}j?\s{1}\d{1,2}\:\d{2}\:\d{2}\s(?:(?:TT)|(?:UT)){1}"
            .$delimiter,
            // Actual 
            RegExPattern::UniversalAndTerrestrialDateTime
        ], [
            // Expected
            $delimiter.'(?:'
            .RegExPattern::OneSpaceDelimeter.'|'
            .RegExPattern::TwoSpaceDelimiter.'|'
            .RegExPattern::ThreeSpaceDelimiter
            .')-?\d+\.\d+\b'
            .$delimiter, 
            // Actual
            RegExPattern::RelativeDecimalNumber
        ], [
            // Expected
            $delimiter."(?:error)(.+)".$delimiter,
            // Actual 
            RegExPattern::SwetestError]
        ];

        // Act & Assert
        foreach ($cases as $case) {
            $this->assertEquals($case[0], $case[1]->value, $this->enumFail($case[1]->name));
        }
    }
}