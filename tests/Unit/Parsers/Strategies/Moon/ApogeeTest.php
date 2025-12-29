<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Parsers\Strategies\Moon;

use RoundingMode;
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
        $text = "Moon       $timestamp  $moon_longitude  $daily_speed";
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
        $text = "intp. Apogee       $timestamp  $moon_longitude  $daily_speed";
        $parser = new Apogee($text);
        
        // Act
        $result = $parser->found();

        // Assert
        $this->assertEquals("intp. Apogee", $result[0]);
        $this->assertEquals($timestamp, $result[1]);
        $this->assertEquals($moon_longitude, $result[2]);
        $this->assertEquals($daily_speed, $result[3]);
    }

    #[TestDox("returns null if some data is missing.")]
    public function test_return_null_if_missing_data(): void
    {
        // Arrange
        $timestamp = $this->getRandomSwissEphemerisDateTime()->toGregorianTT();
        $moon_longitude = $this->round($this->getRandomPositiveSexadecimalValue());
        $daily_speed = $this->round($this->getRandomMoonDailySpeed());
        $astral_object = $this->faker->randomElement(["Moon", "intp. Apogee"]);
        $text_1 = "$timestamp  $moon_longitude  $daily_speed";
        $text_2 = "$astral_object   $moon_longitude  $daily_speed";
        $text_3 = "$astral_object   $timestamp";

        // Act & Assert
        $this->assertNull((new Apogee($text_1))->found());
        $this->assertNull((new Apogee($text_2))->found());
        $this->assertNull((new Apogee($text_3))->found());
    }
}