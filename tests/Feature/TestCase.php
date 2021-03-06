<?php
namespace MarcoConsiglio\Ephemeris\Tests\Feature;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\WithFaker;
use MarcoConsiglio\Ephemeris\EphemerisServiceProvider;
use MarcoConsiglio\Ephemeris\LaravelSwissEphemeris;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithFailureMessage;
use Orchestra\Testbench\Console\Kernel as TestbenchConsoleKernel;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
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
}