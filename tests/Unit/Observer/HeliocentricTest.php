<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Observer;

use AdamBrett\ShellWrapper\Command;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Observer\Heliocentric;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;

#[CoversClass(Heliocentric::class)]
#[TestDox("The Heliocentric PointOfView")]
class HeliocentricTest extends TestCase
{
    #[TestDox("sets the barycentric flag for the Swiss Ephemeris command.")]
    public function test_set_barycentric_flag(): void
    {
        // Arrange
        $command_name = "dummy_command";
        $command = new Command($command_name);
        $pov = new Heliocentric;

        // Act
        $pov->setPointOfView($command, fn() => true);

        // Assert
        $this->assertEquals("$command_name -hel", (string) $command);
    }
}