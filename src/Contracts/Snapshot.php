<?php namespace Michaeljennings\Snapshot\Contracts;

interface Snapshot {

    /**
     * Capture the current state of the application.
     *
     * @param array $additionalData
     */
    public function capture(array $additionalData = array());

    /**
     * Find a snapshot by its id.
     *
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * Find a snapshot by its id and render all of it's data.
     *
     * @param $id
     * @return string
     */
    public function render($id);

}