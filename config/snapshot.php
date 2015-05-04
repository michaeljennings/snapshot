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
     *
     */
    'store' =>  [

        'class' => 'Michaeljennings\\Snapshot\\Store\\Eloquent\\Store',

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
             *  PDO Connection
             * ----------------------------------------------------------------
             *
             * Set the database connection to your store here.
             */
            'connection' => [

                'host' => 'localhost',
                'username' => 'root',
                'password' => 'root',
                'db' => 'packages'

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
    'renderer' => 'Michaeljennings\\Snapshot\\Renderers\\Illuminate',

    /**
     * -------------------------------------------------------------------------
     *  View
     * -------------------------------------------------------------------------
     *
     * Set the view to use to render the snapshots.
     */
    'view' => 'snapshot::bootstrap.snapshot'

];