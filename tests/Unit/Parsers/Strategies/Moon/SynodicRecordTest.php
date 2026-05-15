<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Parsers\Strategies\Moon;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Parsers\Strategies\Moon\SynodicRecord;
use MarcoConsiglio\Ephemeris\Tests\Unit\Parsers\Strategies\TestCase;

#[CoversClass(SynodicRecord::class)]
#[TestDox("The SynodicRecord ParsingStrategy")]
class SynodicRecordTest extends TestCase
{
    public function test_parse_moon_synodic_record(): void
    {
        // Arrange
        $timestamp = $this->randomSwissEphemerisDateTime()->toGregorianTT();
        $angular_distance = $this->randomAngularDistance(precision: 3)->toSexadecimalDegrees()->value;
        $daily_speed = $this->randomMoonDailySpeed()->toSexadecimalDegrees()->value;
        $text = "{$timestamp}_ {$angular_distance}_ $daily_speed";
        $parser = new SynodicRecord($text);

        // Act
        $result = $parser->found();

        // Assert
        $this->assertEquals($timestamp, $result[0]);
        $this->assertEquals($angular_distance, $result[1]);
        $this->assertEquals($daily_speed, $result[2]);
    }
}