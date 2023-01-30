<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use MarcoConsiglio\Ephemeris\Tests\Feature\TestCase;

/**
 * @testdox The swetest:query command
 */
class MoonCommandTest extends TestCase
{
    protected const COMMAND = "swetest:moon_synodic";

    /**
     * @test
     * @testdox is registered.
     */
    public function test_the_command_is_registered()
    {
        // Arrange
        // Act
        $command = $this->artisan(self::COMMAND);

        // Assert
        $command->assertSuccessful();
    }

    /**
     * @test
     * @testdox has a help.
     */
    public function test_has_a_help()
    {
        // Arrange
        // Act
        $output = null;
        $command = $this->artisan(self::COMMAND." --help");
        Artisan::call(self::COMMAND, ["--help"]);

        // Assert
        fwrite(STDOUT, Artisan::output());
        $command->assertSuccessful();
    }
}
