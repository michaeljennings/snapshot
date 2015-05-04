<?php

return [

    /**
     * -------------------------------------------------------------------------
     *  Store
     * -------------------------------------------------------------------------
     *
     * Set the class to use to store the snapshots.
     *
     * Supported: Michaeljennings\\Snapshot\\Store\\Eloquent\\Store
     *            Michaeljennings\\Snapshot\\Store\\PDO\\Store
     *
     */
    'store' =>  [

        'class' => 'Michaeljennings\\Snapshot\\Store\\PDO\\Store',

        'eloquent' => [

            /**
             * ----------------------------------------------------------------
             *  Models
             * ----------------------------------------------------------------
             *
             * Set the models to to be used by the eloquent store.
             *
             */
            'models' => [

                'snapshot' => 'Michaeljennings\Snapshot\Store\Eloquent\Snapshot',

                'item' => 'Michaeljennings\Snapshot\Store\Eloquent\Item'

            ],

        ],

        'pdo' => [

            /**
             * ----------------------------------------------------------------
             *  Database Connection
             * ----------------------------------------------------------------
             *
             * Set which database connection you want to use.
             */
            'connection' => 'mysql',

            /**
             * ----------------------------------------------------------------
             *  PDO Connections
             * ----------------------------------------------------------------
             *
             * Set any database connection details here.
             */
            'connections' => [

                'sqlite' => [
                    'driver' => 'sqlite',
                    'database' => ':memory:',
                ],

                'mysql' => [
                    'driver' => 'mysql',
                    'host' => 'localhost',
                    'username' => 'user',
                    'password' => 'secret',
                    'db' => 'database'

                ]

            ]

        ],

    ],

    /**
     * -------------------------------------------------------------------------
     *  Renderer
     * -------------------------------------------------------------------------
     *
     * Set the class to use to render the snapshots.
     *
     * Supported: Michaeljennings\\Snapshot\\Renderers\\Illuminate
     *            Michaeljennings\\Snapshot\\Renderers\\Native
     *
     */
    'renderer' => 'Michaeljennings\\Snapshot\\Renderers\\Native',

    /**
     * -------------------------------------------------------------------------
     *  View
     * -------------------------------------------------------------------------
     *
     * Set the view to use to render the snapshots.
     */
    'view' => 'snapshot::bootstrap.snapshot'

];