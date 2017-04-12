<?php

use League\Event\Emitter;
use Michaeljennings\Snapshot\Dispatcher;

if ( ! function_exists('snapshot')) {

    /**
     * Get an instance of the snapshot class.
     *
     * @return Snapshot
     */
    function snapshot()
    {
        // Check if we are in a laravel application
        if (function_exists('app')) {
            return app('snapshot');
        }

        $config = require(__DIR__ . '/../config/snapshot.php');

        $store = new $config['store']['class'];
        $renderer = new $config['renderer'];
        $dispatcher = new Dispatcher(new Emitter());

        return new Snapshot($store, $renderer, $dispatcher, $config);
    }

}