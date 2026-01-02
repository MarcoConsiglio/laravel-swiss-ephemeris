<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Observer;

use AdamBrett\ShellWrapper\Command;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Observer\Barycentric;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;

#[CoversClass(Barycentric::class)]
#[TestDox("The Barycentric PointOfView")]
class BarycentricTest extends TestCase
{
    #[TestDox("sets the barycentric flag for the Swiss Ephemeris command.")]
    public function test_set_barycentric_flag(): void
    {
        // Arrange
        $command_name = "dummy_command";
        $command = new Command($command_name);
        $pov = new Barycentric;

        // Act
        $pov->setPointOfView($command, fn() => true);

        // Assert
        $this->assertEquals("$command_name -bary", (string) $command);
    }
}