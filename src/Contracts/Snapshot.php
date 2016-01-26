<?php

namespace Michaeljennings\Snapshot\Contracts;

use Exception;

interface Snapshot
{

    /**
     * Capture the current state of the application.
     */
    public function capture();

    /**
     * Capture an exception, and optionally set a custom message and error code.
     *
     * @param  Exception  $e
     * @param  boolean    $message
     * @param  boolean    $code
     * @param  array|null $additionalData
     * @return int|string
     */
    public function captureException(Exception $e, $message = false, $code = false, $additionalData = null);

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