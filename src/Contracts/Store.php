<?php

namespace Michaeljennings\Snapshot\Contracts;

interface Store
{
    /**
     * Store the current state of the application.
     *
     * @param array $input
     * @return mixed
     */
    public function capture(array $input);
}