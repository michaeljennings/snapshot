<?php

namespace Michaeljennings\Snapshot;

use League\Event\EmitterInterface;
use Michaeljennings\Snapshot\Contracts\Dispatcher as DispatcherContract;

class Dispatcher implements DispatcherContract
{
    /**
     * The event emitter implementation.
     *
     * @var EmitterInterface
     */
    protected $emitter;

    /**
     * Dispatcher constructor.
     *
     * @param EmitterInterface $emitter
     */
    public function __construct(EmitterInterface $emitter)
    {
        $this->emitter = $emitter;
    }

    /**
     * Fire an event.
     *
     * @param mixed $event
     * @param array $data
     * @return \League\Event\EventInterface
     */
    public function emit($event, array $data = [])
    {
        return $this->emitter->emit($event, $data);
    }

    /**
     * Add an event listener.
     *
     * @param mixed $event
     * @param mixed $listener
     * @return $this
     */
    public function listen($event, $listener)
    {
        return $this->emitter->addListener($event, $listener);
    }
}