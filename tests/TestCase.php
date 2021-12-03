<?php
namespace MarcoConsiglio\Ephemeris\Tests;

use Illuminate\Support\Facades\Config;
use MarcoConsiglio\Ephemeris\EphemerisServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Configuration used by the package being tested.
     *  
     * @var array
     */
    protected $config;

    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [EphemerisServiceProvider::class];
    } 

    protected function getEnvironmentSetUp($app)
    {
        $this->config = $app->conf
    }

    /**
     * Resolve application Console Kernel implementation.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function resolveApplicationConsoleKernel($app)
    {

    }

}