<?php

namespace Michaeljennings\Snapshot\Renderers;

use Michaeljennings\Snapshot\Contracts\Renderer;

class Illuminate implements Renderer
{
    /**
     * An instance of the illuminate view class
     *
     * @var mixed
     */
    protected $view;

    public function __construct($view)
    {
        $this->view = $view;
    }

    /**
     * Return the required view.
     *
     * @param       $view
     * @param array $data
     * @return string
     */
    public function make($view, $data = array())
    {
        return $this->view->make($view, $data)->render();
    }
}