<?php

namespace Michaeljennings\Snapshot;

use League\Event\Emitter;
use ReflectionClass;

class Laravel4ServiceProvider extends SnapshotServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->package('michaeljennings/snapshot', 'snapshot', __DIR__ . '/../');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerStore();
        $this->registerRenderer();
        $this->registerDispatcher();

        $this->app->singleton('Michaeljennings\Snapshot\Contracts\Snapshot', function ($app) {
            return new Snapshot(
                $app['Michaeljennings\Snapshot\Contracts\Store'],
                $app['Michaeljennings\Snapshot\Contracts\Renderer'],
                $app['Michaeljennings\Snapshot\Contracts\Dispatcher'],
                $app['config']['snapshot::snapshot']
            );
        });

        $this->app->alias('Michaeljennings\Snapshot\Contracts\Snapshot', 'snapshot');
    }

    /**
     * Register the snapshot store.
     */
    protected function registerStore()
    {
        $this->app->bind('Michaeljennings\Snapshot\Contracts\Store', function ($app) {
            return (new ReflectionClass($app['config']['snapshot::snapshot']['store']['class']))
                ->newInstanceArgs([$app['config']['snapshot::snapshot']]);
        });
    }

    /**
     * Register the snapshot renderer.
     */
    protected function registerRenderer()
    {
        $this->app->bind('Michaeljennings\Snapshot\Contracts\Renderer', function ($app) {
            return (new ReflectionClass($app['config']['snapshot::snapshot']['renderer']))
                ->newInstanceArgs([$app['view']]);
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
}