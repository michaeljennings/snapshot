<?php

namespace Michaeljennings\Snapshot\Tests;

class SnapshotServiceProviderTest extends TestCase
{
    /** @test */
    public function it_resolves_the_snapshot_interface()
    {
        $snapshot = $this->app->make('Michaeljennings\Snapshot\Contracts\Snapshot');
        $this->assertInstanceOf('Michaeljennings\Snapshot\Snapshot', $snapshot);
        $this->assertInstanceOf('Michaeljennings\Snapshot\Contracts\Snapshot', $snapshot);
    }
}
