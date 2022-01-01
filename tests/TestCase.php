<?php
namespace MarcoConsiglio\Ephemeris\Tests;

use App\Console\Kernel as ConsoleKernel;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\WithFaker;
use MarcoConsiglio\Ephemeris\EphemerisServiceProvider;
use MarcoConsiglio\Ephemeris\LaravelSwissEphemeris;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithFailureMessage;
use Orchestra\Testbench\Console\Kernel as TestbenchConsoleKernel;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    use WithFaker, WithFailureMessage;
    
    /**
     * The application configs.
     *  
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * The Swiss Ephemeris Library
     *
     * @var \MarcoConsiglio\Ephemeris\LaravelSwissEphemeris
     */
    protected $ephemeris;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->ephemeris = new LaravelSwissEphemeris(
            $this->app['config']->get("ephemeris.latitude"), 
            $this->app['config']->get("ephemeris.longitude"),
            $this->app['config']->get("ephemeris.timezone")
        );
    }

    protected function getPackageProviders($app)
    {
        return [EphemerisServiceProvider::class];
    } 

    /**
     * Get application timezone.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return string|null
     */
    protected function getApplicationTimezone($app)
    {
        return 'Europe/Rome';
    }


    protected function getEnvironmentSetUp($app)
    {
        $this->config = $app['config'];
    }

    /**
     * Resolve application Console Kernel implementation.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function resolveApplicationConsoleKernel($app)
    {
        $app->alias("config", Repository::class);
        $app->singleton(Kernel::class, TestbenchConsoleKernel::class);
    }

    /**
     * Asserts type and value of a variable.
     *
     * @param string $name
     * @param mixed  $expected_value
     * @param string $expected_type
     * @param mixed $actual_value
     * @return void
     */
    public function assertProperty(string $name, mixed $expected_value, string $expected_type, mixed $actual_value)
    {
        switch ($expected_type) {
            case 'string':
                $this->assertIsString($actual_value, $this->typeFail($name));
                break;
            case 'float':
                $this->assertIsFloat($actual_value, $this->typeFail($name));
                break;
            case 'array':
                $this->assertIsArray($actual_value, $this->typeFail($name));
                break;
            case 'integer':
                $this->assertIsInt($actual_value, $this->typeFail($name));
                break;
            default:
                $this->assertInstanceOf($expected_type, $actual_value, $this->typeFail($name));
                break;
        }
        $this->assertEquals($expected_value, $actual_value, $this->getterFail($name));
    }
}