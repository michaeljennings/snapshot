<?php

namespace Michaeljennings\Snapshot\Contracts;

interface Renderer
{
    /**
     * Return the required view
     *
     * @param       $view
     * @param array $data
     * @return string
     */
    public function make($view, $data = array());
}