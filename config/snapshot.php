<?php

return [

    /**
     * -------------------------------------------------------------------------
     *  Store
     * -------------------------------------------------------------------------
     *
     * Set how you want to store the snapshots. At present only the laravel
     * eloquent ORM, and PDO stores are supported.
     *
     */

    'store' =>  [

        /**
         * -------------------------------------------------------------------------
         *  Class
         * -------------------------------------------------------------------------
         *
         * Set the class to use to store the snapshots.
         *
         * Supported: Michaeljennings\Snapshot\Store\Eloquent\Store
         *            Michaeljennings\Snapshot\Store\PDO\Store
         *
         */

        'class' => 'Michaeljennings\Snapshot\Store\Eloquent\Store',

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
     *  View
     * -------------------------------------------------------------------------
     *
     * Set the view to use to render the snapshots.
     *
     */

    'view' => 'snapshot::bootstrap.snapshot',

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
     * ---------------------------------------------------------------------
     *  Slack Integration
     * ---------------------------------------------------------------------
     *
     * When enabled this will send a message to the specified slack channel
     * to alert you when a snapshot has been captured. This can be very
     * helpful in catching errors before they are reported.
     *
     * For the slack integration we use the awesome mankz/slack message,
     * check https://github.com/maknz/slack/ for more details.
     *
     */

    'slack' => [

        /**
         * ---------------------------------------------------------------------
         *  Enable Slack Integration
         * ---------------------------------------------------------------------
         *
         * Enable this if you want to receive a slack message when a snapshot
         * is captured.
         *
         */

        'enabled' => false,

        /**
         * ---------------------------------------------------------------------
         *  Incoming Webhook Endpoint
         * ---------------------------------------------------------------------
         *
         * The endpoint of you incoming webhook for your slack channel. It will
         * look something like:
         * https://hooks.slack.com/services/XXXXXXXX/XXXXXXXX/XXXXXXXXXXXXXX
         *
         * To generate a new incoming webhook visit
         * https://my.slack.com/services/new/incoming-webhook
         *
         */

        'endpoint' => '',

        'settings' => [

            /**
             * ---------------------------------------------------------------------
             *  Channel
             * ---------------------------------------------------------------------
             *
             * Set the channel message should be sent to. This can either be a
             * specified channel e.g. #foo-channel, a user e.g. @foouser, or you
             * can leave it null to use the default channel for the webhook.
             *
             */

            'channel' => null,

            /**
             * ---------------------------------------------------------------------
             *  Username
             * ---------------------------------------------------------------------
             *
             * Set the default username messages should be sent from.
             *
             */

            'username' => 'Robot',

            /**
             * ---------------------------------------------------------------------
             *  Default Icon
             * ---------------------------------------------------------------------
             *
             * The default icon to use. This can either be a URL to an image or Slack
             * emoji like :ghost: or :heart_eyes:. Set to null to use the default
             * set on the Slack webhook
             *
             */

            'icon' => null,

            /**
             * ---------------------------------------------------------------------
             *  Allow Markdown in Messages
             * ---------------------------------------------------------------------
             *
             * Whether message text should be interpreted in Slack's Markdown-like
             * language. For formatting options, see Slack's help article:
             * http://goo.gl/r4fsdO
             *
             */

            'allow_markdown' => true,

        ]
    ]

];