<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Observer;

use AdamBrett\ShellWrapper\Command;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Observer\Topocentric;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;

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
            $latitude = $this->randomLatitude()->toSexadecimalDegrees()->value(11),
            $longitude = $this->randomLongitude()->toSexadecimalDegrees()->value(11),
            $altitude = $this->positiveRandomInteger(0, 4000)
        );

        // Act
        $pov->setPointOfView($command, fn() => true);

        // Assert
        $this->assertEquals("$command_name -topo[$longitude,$latitude,$altitude]", (string) $command);
    }
}