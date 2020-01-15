<?php

namespace Saadzer\LaravelJobChain;

use Illuminate\Support\ServiceProvider;

class LaravelJobChainServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'jobchain');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes.php');


        $this->publishes([
            __DIR__ . '/database/migrations/' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../config/' => config_path(),
        ], 'config');

        $this->publishes([
            __DIR__.'/resources/views/' => base_path('views/vendor/saadzer/jobchain'),
        ]);
        $this->publishes([
            __DIR__.'/resources/assets' => public_path('vendor/saadzer/jobchain'),
        ], 'public');
        // Publishing is only necessary when using the CLI.
        // if ($this->app->runningInConsole()) {
        //     $this->bootForConsole();
        // }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laraveljobchain.php', 'laraveljobchain');

        // Register the service the package provides.
        // $this->app->singleton('laraveljobchain', function ($app) {
        //     return new LaravelJobChain;
        // });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['LaravelJobChain'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    // protected function bootForConsole()
    // {
    //     // Publishing the configuration file.
    //     $this->publishes([
    //         __DIR__.'/../config/laraveljobchain.php' => config_path('laraveljobchain.php'),
    //     ], 'laraveljobchain.config');

    //     // Publishing the views.
    //     /*$this->publishes([
    //         __DIR__.'/../resources/views' => base_path('resources/views/vendor/saadzer'),
    //     ], 'laraveljobchain.views');*/

    //     // Publishing assets.
    //     /*$this->publishes([
    //         __DIR__.'/../resources/assets' => public_path('vendor/saadzer'),
    //     ], 'laraveljobchain.views');*/

    //     // Publishing the translation files.
    //     /*$this->publishes([
    //         __DIR__.'/../resources/lang' => resource_path('lang/vendor/saadzer'),
    //     ], 'laraveljobchain.views');*/

    //     // Registering package commands.
    //     // $this->commands([]);
    // }
}
