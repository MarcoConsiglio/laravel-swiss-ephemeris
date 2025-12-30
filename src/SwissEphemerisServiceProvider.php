<?php

namespace MarcoConsiglio\Ephemeris;

use Illuminate\Support\ServiceProvider;

/**
 * @codeCoverageIgnore
 */
class SwissEphemerisServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'ephemeris');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'ephemeris');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing the package configuration file.
        $this->publishes([
            __DIR__.'/../config/ephemeris.php' => config_path('ephemeris.php'),
        ], 'swiss-ephemeris-config');

        // Publishing the Swiss Ephemeris library.
        $lib = 'swiss_ephemeris/';
        $this->publishes([
            './lib/swetest' => resource_path($lib.'swetest'),
            './lib/seas_18.se1' => resource_path($lib.'seas_18.se1'),
            './lib/semo_18.se1' => resource_path($lib.'semo_18.se1'),
            './lib/sepl_18.se1' => resource_path($lib.'sepl_18.se1'),
        ], 'swiss-ephemeris');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/ephemeris'),
        ], 'views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/ephemeris'),
        ], 'assets');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/ephemeris'),
        ], 'lang');*/

        // if ($this->app->runningInConsole()) {
            // Registering package commands.
            // $this->commands([
            //     EphemerisCommand::class
            // ]);
        // }
    }

    /**
     * Register the application services.
     */
    #[\Override]
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/ephemeris.php', 'ephemeris');

        // Register the main class to use with the facade
        // $this->app->singleton('ephemeris', function () {
        //     return new Ephemeris;
        // });
    }
}
