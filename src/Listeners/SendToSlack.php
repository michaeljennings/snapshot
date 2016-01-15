<?php

namespace Michaeljennings\Snapshot\Listeners;

use League\Event\EventInterface;
use Maknz\Slack\Client;
use Michaeljennings\Snapshot\Exceptions\EndPointNotSetException;

class SendToSlack extends Listener
{
    /**
     * Check if slack is enabled, if so send the snapshot to the relevant
     * channel.
     *
     * @param EventInterface $event
     * @throws EndPointNotSetException
     */
    public function handle(EventInterface $event)
    {
        if ($this->config['slack']['enabled']) {
            if (empty($this->config['slack']['endpoint'])) {
                throw new EndPointNotSetException("You must set the endpoint for your slack channel.");
            }

            $client = new Client($this->config['slack']['endpoint'], $this->config['slack']['settings']);
            $snapshot = $event->getSnapshot();

            $client->send('A new snapshot has been captured. #' . $snapshot->getId());
        }
    }
}