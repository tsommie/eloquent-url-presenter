<?php

namespace AcDevelopers\EloquentUrlPresenter\LaravelLumen;

use AcDevelopers\EloquentUrlPresenter\LaravelLumen\Console\Commands\MakeUrlPresenterCommand;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;

/**
 * Class EloquentUrlPresenterServiceProvider
 *
 * @package AcDevelopers\EloquentUrlPresenter\LaravelLumen
 */
class EloquentUrlPresenterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app instanceof LaravelApplication) {
            $this->publishes([
                __DIR__.'/../../config/LaravelLumen/config.php' => config_path('ac-developers/eloquent-url-presenter.php'),
            ], 'config');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('laravel-form-processor');
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeUrlPresenterCommand::class,
            ]);
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/LaravelLumen/config.php', 'eloquent-url-presenter'
        );
    }
}
