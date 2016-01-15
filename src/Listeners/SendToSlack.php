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

            $client->send($this->getMessage($event->getSnapshot()));
        }
    }

    /**
     * Get the slack message for the snapshot. If you wish to use markdown
     * then set the allow_markdown config option to true.
     *
     * @param mixed $snapshot
     * @return string
     */
    protected function getMessage($snapshot)
    {
        return '#' . $snapshot->getId() . ' A new snapshot has been captured';
    }
}