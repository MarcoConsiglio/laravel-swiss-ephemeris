<?php
namespace MarcoConsiglio\Ephemeris\Test\Unit\Observer;

use AdamBrett\ShellWrapper\Command;
use MarcoConsiglio\Ephemeris\Enums\SinglePlanet;
use MarcoConsiglio\Ephemeris\Observer\Planetocentric;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[CoversClass(Planetocentric::class)]
#[TestDox("The Planetocentric PointOfView")]
class PlanetocentricTest extends TestCase
{
    #[TestDox("sets the barycentric flag for the Swiss Ephemeris command.")]
    public function test_set_barycentric_flag(): void
    {
        // Arrange
        $command_name = "dummy_command";
        $planet = SinglePlanet::Mars;
        $command = new Command($command_name);
        $pov = new Planetocentric($planet);

        // Act
        $pov->setPointOfView($command, fn() => true);

        // Assert
        $this->assertEquals("$command_name -pc".$planet->value, (string) $command);
    }
}