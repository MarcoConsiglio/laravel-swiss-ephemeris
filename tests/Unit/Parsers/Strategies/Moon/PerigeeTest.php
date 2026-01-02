<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Parsers\Strategies\Moon;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Parsers\Strategies\Moon\Perigee;
use MarcoConsiglio\Ephemeris\Tests\Unit\Parsers\Strategies\TestCase;

#[CoversClass(Perigee::class)]
#[TestDox("The Perigee ParsingStrategy")]
class PerigeeTest extends TestCase
{
    #[TestDox("can parse moon data.")]
    public function test_parse_moon_data(): void
    {
        // Arrange
        $timestamp = $this->getRandomSwissEphemerisDateTime()->toGregorianTT();
        $moon_longitude = $this->round($this->getRandomPositiveSexadecimalValue());
        $daily_speed = $this->round($this->getRandomMoonDailySpeed());
        $text = "Moon  _     {$timestamp}_  {$moon_longitude}_  $daily_speed";
        $parser = new Perigee($text);
        
        // Act
        $result = $parser->found();

        // Assert
        $this->assertEquals("Moon", $result[0]);
        $this->assertEquals($timestamp, $result[1]);
        $this->assertEquals($moon_longitude, $result[2]);
        $this->assertEquals($daily_speed, $result[3]);
    }

    #[TestDox("can parse perigee data.")]
    public function test_parse_perigee_data(): void
    {
        // Arrange
        $timestamp = $this->getRandomSwissEphemerisDateTime()->toGregorianTT();
        $moon_longitude = $this->round($this->getRandomPositiveSexadecimalValue());
        $daily_speed = $this->round($this->getRandomMoonDailySpeed());
        $text = "intp. Perigee   _    {$timestamp}_  {$moon_longitude}_  $daily_speed";
        $parser = new Perigee($text);
        
        // Act
        $result = $parser->found();

        // Assert
        $this->assertEquals("intp. Perigee", $result[0]);
        $this->assertEquals($timestamp, $result[1]);
        $this->assertEquals($moon_longitude, $result[2]);
        $this->assertEquals($daily_speed, $result[3]);
    }
}