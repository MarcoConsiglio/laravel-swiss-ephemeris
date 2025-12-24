<?php
namespace MarcoConsiglio\Ephemeris\Tests\Feature;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Config;
use Orchestra\Testbench\Console\Kernel as TestbenchConsoleKernel;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Orchestra\Workbench\WorkbenchServiceProvider;
use MarcoConsiglio\Ephemeris\LaravelSwissEphemeris;
use MarcoConsiglio\Ephemeris\SwissEphemerisServiceProvider;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithFailureMessage;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithRandomData;

/**
 * Feature custom TestCase.
 */
abstract class TestCase extends OrchestraTestCase
{
    use WithFailureMessage, WithRandomData;
    
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
    #[\Override]
    public function setUp(): void
    {
        parent::setUp();
        $this->createApplication();
        $this->ephemeris = new LaravelSwissEphemeris(
            // new TopocentricLocale(
            //     Config::get("ephemeris.latitude"), 
            //     Config::get("ephemeris.longitude"),
            //     Config::get("ephemeris.altitude")
            // ),
            null,
            Config::get("ephemeris.timezone")
        );
        $this->setUpFaker();
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app) 
    {
        tap($app['config'], function (Repository $config): void { 
            $config->set('ephemeris', [
                'latitude' => 51.47783333,
                'longitude' => 0.0,
                'altitude' => 0,
                'timezone' => 'Europe/London'
            ]);
        });
    }

    protected function getPackageProviders($app)
    {
        return [
            SwissEphemerisServiceProvider::class,
            WorkbenchServiceProvider::class
        ];
    } 

    /**
     * Get application timezone.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return string|null
     */
    protected function getApplicationTimezone($app)
    {
        return 'Europe/London';
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