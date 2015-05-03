<?php namespace Michaeljennings\Snapshot; 

use Illuminate\Support\ServiceProvider;

class SnapshotServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/snapshot.php' => config_path('snapshot.php'),
            __DIR__.'/../database/migrations/' => base_path('database/migrations')
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/snapshot.php', 'snapshot');

        $this->registerStore();
        $this->registerRenderer();

        $this->app->singleton('Michaeljennings\Snapshot\Contracts\Snapshot', function($app)
        {
            return new Snapshot(
                $app['Michaeljennings\Snapshot\Contracts\Store'],
                $app['Michaeljennings\Snapshot\Contracts\Renderer']
            );
        });

        $this->app->bind('michaeljennings.snapshot', function($app)
        {
            return $app['Michaeljennings\Snapshot\Contracts\Snapshot'];
        });
    }

    /**
     * Register the snapshot store.
     */
    protected function registerStore()
    {
        $store = config('snapshot.store');

        $this->app->bind('Michaeljennings\Snapshot\Contracts\Store', function() use ($store)
        {
            return new $store;
        });
    }

    /**
     * Register the snapshot renderer.
     */
    protected function registerRenderer()
    {
        $renderer = config('snapshot.renderer');

        $this->app->bind('Michaeljennings\Snapshot\Contracts\Renderer', function($app) use($renderer)
        {
            return (new \ReflectionClass($renderer))->newInstanceArgs([$app['view']]);
        });
    }

}