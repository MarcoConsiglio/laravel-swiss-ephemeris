<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Parsers\Strategies\Moon;

use RoundingMode;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Parsers\Strategies\Moon\Node;
use MarcoConsiglio\Ephemeris\Tests\Unit\Parsers\Strategies\TestCase;

#[CoversClass(Node::class)]
#[TestDox("The Node ParsingStrategy")]
class NodeTest extends TestCase
{
    #[TestDox("can parse moon data.")]
    public function test_parse_moon_data(): void
    {
        // Arrange
        $timestamp = $this->getRandomSwissEphemerisDateTime()->toGregorianTT();
        $moon_longitude = $this->round($this->getRandomPositiveSexadecimalValue());
        $daily_speed = $this->round($this->getRandomMoonDailySpeed());
        $text = "Moon       $timestamp  $moon_longitude  $daily_speed";
        $parser = new Node($text);
        
        // Act
        $result = $parser->found();

        // Assert
        $this->assertEquals("Moon", $result[0]);
        $this->assertEquals($timestamp, $result[1]);
        $this->assertEquals($moon_longitude, $result[2]);
        $this->assertEquals($daily_speed, $result[3]);
    }

    #[TestDox("can parse lunar node data.")]
    public function test_parse_node_data(): void
    {
        // Arrange
        $timestamp = $this->getRandomSwissEphemerisDateTime()->toGregorianTT();
        $moon_longitude = $this->round($this->getRandomPositiveSexadecimalValue());
        $daily_speed = $this->round($this->getRandomMoonDailySpeed());
        $text = "true Node       $timestamp  $moon_longitude  $daily_speed";
        $parser = new Node($text);
        
        // Act
        $result = $parser->found();

        // Assert
        $this->assertEquals("true Node", $result[0]);
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
        $astral_object = $this->faker->randomElement(["Moon", "true Node"]);
        $text_1 = "$timestamp  $moon_longitude  $daily_speed";
        $text_2 = "$astral_object   $moon_longitude  $daily_speed";
        $text_3 = "$astral_object   $timestamp";

        // Act & Assert
        $this->assertNull((new Node($text_1))->found());
        $this->assertNull((new Node($text_2))->found());
        $this->assertNull((new Node($text_3))->found());
    }
}