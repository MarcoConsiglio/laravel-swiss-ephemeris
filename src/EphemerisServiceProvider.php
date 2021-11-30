<?php

namespace MarcoConsiglio\Ephemeris;

use Illuminate\Support\ServiceProvider;
use MarcoConsiglio\Ephemeris\Commands\EphemerisCommand;

class EphemerisServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        if($this->app->runningInConsole()) {
            $this->commands([
                EphemerisCommand::class
            ]);
        }
    }
}
