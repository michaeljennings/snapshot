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
        // Set the directory to load views from
        $this->loadViewsFrom(__DIR__.'/../views', 'snapshot');

        // Set the files to publish
        $this->publishes([
            __DIR__.'/../config/snapshot.php' => config_path('snapshot.php'),
            __DIR__.'/../database/migrations/' => base_path('database/migrations')
        ]);
        
        $this->mergeConfigFrom(__DIR__.'/../config/snapshot.php', 'snapshot');
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

        $this->app->singleton('Michaeljennings\Snapshot\Contracts\Snapshot', function($app)
        {
            return new Snapshot(
                $app['Michaeljennings\Snapshot\Contracts\Store'],
                $app['Michaeljennings\Snapshot\Contracts\Renderer'],
                config('snapshot')
            );
        });

        $this->app->alias('Michaeljennings\Snapshot\Contracts\Snapshot', 'michaeljennings.snapshot');
    }

    /**
     * Register the snapshot store.
     */
    protected function registerStore()
    {
        $store = config('snapshot.store.class');

        $this->app->bind('Michaeljennings\Snapshot\Contracts\Store', function() use ($store)
        {
            return (new \ReflectionClass($store))->newInstanceArgs([config('snapshot')]);
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