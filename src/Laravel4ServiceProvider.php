<?php

namespace Michaeljennings\Snapshot;

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
     * Get the package config.
     *
     * @return array
     */
    protected function getConfig()
    {
        \Config::addNamespace('snapshot', realpath(__DIR__ . '/../config'));

        return $this->app['config']['snapshot::snapshot'];
    }
}