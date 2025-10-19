<?php

namespace MarcoConsiglio\Ephemeris\Tests\Unit\Enums;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Enums\OutputFormat;
use PHPUnit\Framework\Attributes\CoversClass;

#[TestDox("The OutputFormat enumeration")]
#[CoversClass(OutputFormat::class)]
class OutputFormatTest extends TestCase
{
    #[TestDox("consists of several column type used to format response data.")]   
    public function test_output_formats(): void
    {
        // Arrange
        $failure_message = function (string $constant) {
            return "The $constant enumeration value is not working.";
        };
        $cases = [
            ["y",   OutputFormat::Year],
            ["Y",   OutputFormat::YearFraction],
            ["p",   OutputFormat::PlanetIndex],
            ["P",   OutputFormat::PlanetName],
            ["J",   OutputFormat::JulianDateFormat],
            ["T",   OutputFormat::GregorianDateFormat],
            ["t",   OutputFormat::IntegerDateFormat],
            ["L",   OutputFormat::LongitudeDegree],
            ["l",   OutputFormat::LongitudeDecimal],
            ["Z",   OutputFormat::RelativeLongitudeDegree],
            ["S",   OutputFormat::DailyLongitudinalSpeedDegree],
            ["s",   OutputFormat::DailyLongitudinalSpeedDecimal],
            ["B",   OutputFormat::LatitudeDegree],
            ["b",   OutputFormat::LatitudeDecimal],
            ["R",   OutputFormat::DistanceAU],
            ["W",   OutputFormat::DistanceLightYears],
            ["w",   OutputFormat::DistanceKilometers],
            ["A",   OutputFormat::RightAscensionDegree],
            ["a",   OutputFormat::RightAscensionHoursDecimal],
            ["D",   OutputFormat::DeclinationDegree],
            ["d",   OutputFormat::DeclinationDecimal],
            ["I",   OutputFormat::AzimuthDegree],
            ["i",   OutputFormat::AzimuthDecimal],
            ["H",   OutputFormat::AltitudeDegree],
            ["h",   OutputFormat::AltitudeDecimals],
            ["G",   OutputFormat::HousePositionDegree],
            ["g",   OutputFormat::HousePositionDegreeDecimals],
            ["j",   OutputFormat::HouseNumber],
            ["X",   OutputFormat::EclipticalCoordinates],
            ["x",   OutputFormat::EquatorialCoordinates],
            ["n",   OutputFormat::MeanNodes],
            ["N",   OutputFormat::OsculatingNodes],
            ["f",   OutputFormat::MeanApsides],
            ["F",   OutputFormat::OsculatingApsides],
            ["+",   OutputFormat::PhaseAngle],
            ["-",   OutputFormat::Phase],
            ["*",   OutputFormat::Elongation],
            ["/",   OutputFormat::AppearentDiscDiameter],
            ["=",   OutputFormat::Magnitude]
        ];

        // Act & Assert
        foreach ($cases as $case) {
            $this->assertEquals($case[0], $case[1]->value, $failure_message($case[1]->name));
        }

    }
}
