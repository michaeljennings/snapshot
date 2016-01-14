<?php

namespace Michaeljennings\Snapshot\Events;

use Michaeljennings\Snapshot\Contracts\Snapshot;

class SnapshotCaptured extends Event
{
    /**
     * The captured snapshot.
     *
     * @var Snapshot
     */
    protected $snapshot;

    public function __construct(Snapshot $snapshot)
    {
        $this->snapshot = $snapshot;

        parent::__construct();
    }

    /**
     * Get the snapshot.
     *
     * @return Snapshot
     */
    public function getSnapshot()
    {
        return $this->snapshot;
    }
}