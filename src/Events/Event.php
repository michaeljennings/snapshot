<?php

namespace Michaeljennings\Snapshot\Events;

use League\Event\Event as BaseEvent;
use League\Event\EventInterface;

class Event extends BaseEvent implements EventInterface
{
    public function __construct()
    {
        parent::__construct(get_called_class());
    }
}