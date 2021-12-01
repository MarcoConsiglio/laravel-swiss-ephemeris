<?php

namespace MarcoConsiglio\Ephemeris;

use Illuminate\Support\ServiceProvider;

class EphemerisServiceProvider extends ServiceProvider
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

        if ($this->app->runningInConsole()) {
            // $this->publishes([
            //     __DIR__.'/../config/config.php' => config_path('ephemeris.php'),
            // ], 'config');

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

            // Registering package commands.
            $this->commands([
                EphemerisCommand::class
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'ephemeris');

        // Register the main class to use with the facade
        $this->app->singleton('ephemeris', function () {
            return new Ephemeris;
        });
    }
}
