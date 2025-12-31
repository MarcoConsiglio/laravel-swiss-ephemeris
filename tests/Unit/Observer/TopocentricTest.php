<?php
namespace MarcoConsiglio\Ephemeris\Test\Unit\Observer;

use AdamBrett\ShellWrapper\Command;
use MarcoConsiglio\Ephemeris\Observer\Topocentric;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[CoversClass(Topocentric::class)]
#[TestDox("The Topocentric PointOfView")]
class TopocentricTest extends TestCase
{
    #[TestDox("sets the barycentric flag for the Swiss Ephemeris command.")]
    public function test_set_barycentric_flag(): void
    {
        // Arrange
        $command_name = "dummy_command";
        $command = new Command($command_name);
        $pov = new Topocentric(
            $latitude = $this->faker->randomFloat(11, -90, 90),
            $longitude = $this->faker->randomFloat(11, -90, 90),
            $altitude = $this->faker->numberBetween(0, 4000)
        );

        // Act
        $pov->setPointOfView($command, fn() => true);

        // Assert
        $this->assertEquals("$command_name -topo[$longitude,$latitude,$altitude]", (string) $command);
    }
}