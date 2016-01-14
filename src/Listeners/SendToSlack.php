<?php

namespace Michaeljennings\Snapshot\Listeners;

use League\Event\EventInterface;

class SendToSlack extends Listener
{
    /**
     * Check if slack is enabled, if so send the snapshot to the relevant
     * channel.
     *
     * @param EventInterface $event
     */
    public function handle(EventInterface $event)
    {
        if ($this->config['slack']['enabled']) {
            dd('i got here');
        }
    }
}