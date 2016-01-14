<?php

namespace Michaeljennings\Snapshot\Events;

class SnapshotCaptured extends Event
{
    /**
     * The captured snapshot.
     *
     * @var Snapshot
     */
    protected $snapshot;

    public function __construct($snapshot)
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