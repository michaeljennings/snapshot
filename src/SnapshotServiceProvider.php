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

        $this->app->singleton('Michaeljennings\Snapshot\Contracts\Snapshot', function($app)
        {
            return new Snapshot($app['Michaeljennings\Snapshot\Contracts\Store']);
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

}