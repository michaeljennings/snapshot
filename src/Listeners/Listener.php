<?php

namespace Michaeljennings\Snapshot\Listeners;

use League\Event\AbstractListener;

abstract class Listener extends AbstractListener
{
    /**
     * The snapshot config.
     *
     * @var array
     */
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }
}