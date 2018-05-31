<?php

namespace Michaeljennings\Snapshot;

use Illuminate\Support\ServiceProvider;
use League\Event\Emitter;

class SnapshotServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Set the directory to load views from
        $this->loadViewsFrom(__DIR__ . '/../views', 'snapshot');

        // Set the files to publish
        $this->publishes([
            __DIR__ . '/../config/snapshot.php' => config_path('snapshot.php'),
            __DIR__ . '/../database/migrations/' => base_path('database/migrations')
        ], 'snapshot');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/snapshot.php', 'snapshot');
        
        $this->registerStore();
        $this->registerRenderer();
        $this->registerDispatcher();

        $config = $this->getConfig();

        $this->app->singleton('Michaeljennings\Snapshot\Contracts\Snapshot', function ($app) use ($config) {
            return new Snapshot(
                $app['Michaeljennings\Snapshot\Contracts\Store'],
                $app['Michaeljennings\Snapshot\Contracts\Renderer'],
                $app['Michaeljennings\Snapshot\Contracts\Dispatcher'],
                $config
            );
        });

        $this->app->alias('Michaeljennings\Snapshot\Contracts\Snapshot', 'snapshot');
    }

    /**
     * Register the snapshot store.
     */
    protected function registerStore()
    {
        $store = $this->getConfig()['store']['class'];

        $this->app->bind('Michaeljennings\Snapshot\Contracts\Store', function () use ($store) {
            return (new \ReflectionClass($store))->newInstanceArgs([$this->getConfig()]);
        });
    }

    /**
     * Register the snapshot renderer.
     */
    protected function registerRenderer()
    {
        $renderer = $this->getConfig()['renderer'];

        $this->app->bind('Michaeljennings\Snapshot\Contracts\Renderer', function ($app) use ($renderer) {
            return (new \ReflectionClass($renderer))->newInstanceArgs([$app['view']]);
        });
    }

    /**
     * Register the snapshot event dispatcher.
     */
    protected function registerDispatcher()
    {
        $this->app->singleton('Michaeljennings\Snapshot\Contracts\Dispatcher', function() {
            return new Dispatcher(new Emitter());
        });
    }

    /**
     * Get the package config.
     *
     * @return array
     */
    protected function getConfig()
    {
        return config('snapshot');
    }
}
