<?php

namespace Michaeljennings\Snapshot\Contracts;

interface Dispatcher
{
    /**
     * Fire an event.
     *
     * @param mixed $event
     * @param array $data
     * @return \League\Event\EventInterface
     */
    public function emit($event, array $data);

    /**
     * Add an event listener.
     *
     * @param mixed $event
     * @param mixed $listener
     * @return \Michaeljennings\Snapshot\Dispatcher
     */
    public function listen($event, $listener);
}