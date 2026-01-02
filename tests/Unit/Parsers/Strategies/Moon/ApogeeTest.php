<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Parsers\Strategies\Moon;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Parsers\Strategies\Moon\Apogee;
use MarcoConsiglio\Ephemeris\Tests\Unit\Parsers\Strategies\TestCase;

#[CoversClass(Apogee::class)]
#[TestDox("The Apogee ParsingStrategy")]
class ApogeeTest extends TestCase
{
    #[TestDox("can parse moon data.")]
    public function test_parse_moon_data(): void
    {
        // Arrange
        $timestamp = $this->getRandomSwissEphemerisDateTime()->toGregorianTT();
        $moon_longitude = $this->round($this->getRandomPositiveSexadecimalValue());
        $daily_speed = $this->round($this->getRandomMoonDailySpeed());
        $text = "Moon_       {$timestamp}_  {$moon_longitude}_  {$daily_speed}";
        $parser = new Apogee($text);
        
        // Act
        $result = $parser->found();

        // Assert
        $this->assertEquals("Moon", $result[0]);
        $this->assertEquals($timestamp, $result[1]);
        $this->assertEquals($moon_longitude, $result[2]);
        $this->assertEquals($daily_speed, $result[3]);
    }

    #[TestDox("can parse apogee data.")]
    public function test_parse_apogee_data(): void
    {
        // Arrange
        $timestamp = $this->getRandomSwissEphemerisDateTime()->toGregorianTT();
        $moon_longitude = $this->round($this->getRandomPositiveSexadecimalValue());
        $daily_speed = $this->round($this->getRandomMoonDailySpeed());
        $text = "intp. Apogee     _  {$timestamp}_  {$moon_longitude}_  $daily_speed";
        $parser = new Apogee($text);
        
        // Act
        $result = $parser->found();

        // Assert
        $this->assertEquals("intp. Apogee", $result[0]);
        $this->assertEquals($timestamp, $result[1]);
        $this->assertEquals($moon_longitude, $result[2]);
        $this->assertEquals($daily_speed, $result[3]);
    }
}