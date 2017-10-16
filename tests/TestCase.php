<?php

namespace Michaeljennings\Snapshot\Tests;

use Mockery as m;
use Hash;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        // Set up snapshot config
        $app['config']->set('snapshot.store', [
            'class' => 'Michaeljennings\Snapshot\Store\Eloquent\Store'
        ]);
        $app['config']->set('snapshot', [
            'renderer' => 'Michaeljennings\\Snapshot\\Renderers\\Illuminate',
            'store' => [
                'class' => 'Michaeljennings\Snapshot\Store\Eloquent\Store'
            ],
            'listeners' => [

                'Michaeljennings\Snapshot\Events\SnapshotCaptured' => [
                    'Michaeljennings\Snapshot\Listeners\SendToSlack'
                ]

            ]
        ]);

        return [
            \Michaeljennings\Snapshot\SnapshotServiceProvider::class,
        ];
    }

    public function setUp()
    {
        parent::setUp();
        $this->artisan('migrate', [
            '--database' => 'testbench'
        ]);
        $this->withFactories(__DIR__.DIRECTORY_SEPARATOR.'factories');
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        // Set user model
        Hash::setRounds(5);
    }

    public function tearDown()
    {
        m::close();
        parent::tearDown();
    }
}
