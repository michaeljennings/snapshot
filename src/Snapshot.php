<?php namespace Michaeljennings\Snapshot;

use Michaeljennings\Snapshot\Contracts\Store;
use Michaeljennings\Snapshot\Contracts\Renderer;
use Michaeljennings\Snapshot\Contracts\Snapshot as SnapshotContract;

class Snapshot implements SnapshotContract {

    /**
     * An instance of a snapshot store.
     *
     * @var Store
     */
    protected $store;

    /**
     * An instance of a snapshot renderer.
     *
     * @var Renderer
     */
    protected $renderer;

    /**
     * The package configuration.
     *
     * @var array
     */
    protected $config;

    public function __construct(Store $store, Renderer $renderer, array $config)
    {
        $this->store = $store;
        $this->renderer = $renderer;
        $this->config = $config;
    }

    /**
     * Capture the current state of the application.
     *
     * @param array $additionalData
     */
    public function capture(array $additionalData = array())
    {
        $data = [];
        $stackTrace = debug_backtrace();

        $data['snapshot'] = [
                'file' => $this->getCalledFile($stackTrace),
                'line' => $this->getCalledLine($stackTrace),
                'server' => json_encode($_SERVER),
                'post' => ! empty($_POST) ? json_encode($_POST) : null,
                'get' => ! empty($_GET) ? json_encode($_GET) : null,
                'files' => ! empty($_FILES) ? json_encode($_FILES) : null,
                'cookies' => ! empty($_COOKIE) ? json_encode($_COOKIE) : null,
                'session' => ! empty($_SESSION) ? json_encode($_SESSION) : null,
                'environment' => json_encode($_ENV)
            ] + $additionalData;

        $data['items'] = $this->transformStackTrace($stackTrace);

        $this->store->capture($data);
    }

    /**
     * Find a snapshot by its id.
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->store->find($id);
    }

    /**
     * Find a snapshot by its id and render all of it's data.
     *
     * @param $id
     * @return string
     */
    public function render($id)
    {
        return $this->renderer->make($this->config['view'], [
            'snapshot' => $this->store->find($id)
        ]);
    }

    /**
     * Transform all items in the stack trace.
     *
     * @param array $stackTrace
     * @return array
     */
    protected function transformStackTrace(array $stackTrace)
    {
        $transformedStackTrace = [];

        foreach ($stackTrace as $trace) {
            $transformedStackTrace[] = $this->transformTrace($trace);
        }

        return $transformedStackTrace;
    }

    /**
     * Ensure all of the elements in the stack trace can be saved in a store.
     *
     * @param array $trace
     * @return array
     */
    protected function transformTrace(array $trace)
    {
        if (isset($trace['object'])) $trace['object'] = json_encode($trace['object']);

        if (isset($trace['args'])) $trace['args'] = json_encode($trace['args']);

        return $trace;
    }

    /**
     * Get the file where the snapshot was requested.
     *
     * @param array $stackTrace
     * @return mixed
     */
    protected function getCalledFile(array $stackTrace)
    {
        return $stackTrace[0]['file'];
    }

    /**
     * Get the line the snapshot was requested on.
     *
     * @param array $stackTrace
     * @return mixed
     */
    protected function getCalledLine(array $stackTrace)
    {
        return $stackTrace[0]['line'];
    }
	
}