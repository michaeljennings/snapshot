<?php

namespace Michaeljennings\Snapshot;

use Exception;
use Michaeljennings\Snapshot\Contracts\Dispatcher;
use Michaeljennings\Snapshot\Contracts\Snapshot as SnapshotStore;
use Michaeljennings\Snapshot\Contracts\Store;
use Michaeljennings\Snapshot\Contracts\Renderer;
use Michaeljennings\Snapshot\Contracts\Snapshot as SnapshotContract;
use Michaeljennings\Snapshot\Events\SnapshotCaptured;

class Snapshot implements SnapshotContract
{
    /**
     * The snapshot store implementation.
     *
     * @var Store
     */
    protected $store;

    /**
     * The snapshot renderer implementation.
     *
     * @var Renderer
     */
    protected $renderer;

    /**
     * The event dispatcher implementation.
     *
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * The package configuration.
     *
     * @var array
     */
    protected $config;

    /**
     * Snapshot constructor.
     *
     * @param Store      $store
     * @param Renderer   $renderer
     * @param Dispatcher $dispatcher
     * @param array      $config
     */
    public function __construct(Store $store, Renderer $renderer, Dispatcher $dispatcher, array $config)
    {
        $this->store = $store;
        $this->renderer = $renderer;
        $this->dispatcher = $dispatcher;
        $this->config = $config;

        foreach ($this->config['listeners'] as $event => $listeners) {
            foreach ($listeners as $listener) {
                $this->addListener($event, new $listener($config));
            }
        }
    }

    /**
     * Capture the current state of the application.
     *
     * @return int|string
     */
    public function capture()
    {
        $snapshot = $this->getServerInfo();
        list($stackTrace, $additionalData) = $this->formatArguments(func_get_args());

        return $this->captureSnapshot($snapshot, $stackTrace, $additionalData);
    }

    /**
     * Capture an exception, and optionally set a custom message and error code.
     *
     * @param  Exception  $e
     * @param  boolean    $message
     * @param  boolean    $code
     * @param  array|null $additionalData
     * @return int|string
     */
    public function captureException(Exception $e, $message = false, $code = false, $additionalData = null)
    {
        $snapshot = $this->getServerInfo();
        $stackTrace = $e->getTrace();

        $snapshot['message'] = $message ? $message : $e->getMessage();
        $snapshot['code'] = $code ? $code : $e->getCode();

        return $this->captureSnapshot($snapshot, $stackTrace, $additionalData);
    }

    /**
     * Store the snapshot and then fire the snapshot captured event.
     * Return's the id of the last snapshot captured.
     *
     * @param array      $snapshot
     * @param array      $stackTrace
     * @param array|null $additionalData
     * @return mixed
     */
    protected function captureSnapshot(array $snapshot, array $stackTrace, $additionalData = null)
    {
        $snapshot = $this->storeSnapshot($snapshot, $stackTrace, $additionalData);

        $this->dispatcher->emit(new SnapshotCaptured($snapshot));

        return $snapshot->getId();
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
     * Store a snapshot and then return its id.
     *
     * @param  array      $snapshot
     * @param  array      $stackTrace
     * @param  array|null $additionalData
     * @return SnapshotStore
     */
    protected function storeSnapshot(array $snapshot, array $stackTrace, $additionalData = null)
    {
        $data['snapshot'] = $snapshot;
        $data['snapshot']['additional_data'] = ! is_null($additionalData) ? json_encode($additionalData) : null;
        $data['items'] = $this->transformStackTrace($stackTrace);

        return $this->store->capture($data);
    }

    /**
     * Format the captured arguments.
     *
     * @param array $args
     * @return array
     */
    protected function formatArguments(array $args)
    {
        $additionalData = [];

        foreach ($args as $arg) {
            if ($arg instanceof \Exception) {
                $stackTrace = $arg->getTrace();
                $snapshot['message'] = $arg->getMessage();
                $snapshot['code'] = $arg->getCode();
            }

            if (is_array($arg)) {
                $additionalData = array_merge($additionalData, $arg);
            }
        }

        if ( ! isset($stackTrace)) {
            $stackTrace = debug_backtrace();
        }

        return [$stackTrace, $additionalData];
    }

    /**
     * Get the data needed to create a snapshot.
     *
     * @return array
     */
    protected function getServerInfo()
    {
        $stackTrace = debug_backtrace();

        $file = $this->getCalledFile($stackTrace);
        $line = $this->getCalledLine($stackTrace);

        return [
            'file' => $file,
            'line' => $line,
            'server' => ! empty($_SERVER) ? json_encode($_SERVER) : null,
            'post' => ! empty($_POST) ? json_encode($_POST) : null,
            'get' => ! empty($_GET) ? json_encode($_GET) : null,
            'files' => ! empty($_FILES) ? json_encode($_FILES) : null,
            'cookies' => ! empty($_COOKIE) ? json_encode($_COOKIE) : null,
            'session' => ! empty($_SESSION) ? json_encode($_SESSION) : null,
            'environment' => ! empty($_ENV) ? json_encode($_ENV) : null
        ];
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
        if (isset($trace['object'])) {
            $trace['object'] = json_encode($trace['object']);
        }

        if (isset($trace['args'])) {
            $trace['args'] = json_encode($trace['args']);
        }

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

    /**
     * Add an event listener.
     *
     * @param mixed $event
     * @param mixed $listener
     * @return $this
     */
    public function addListener($event, $listener)
    {
        $this->dispatcher->listen($event, $listener);

        return $this;
    }
}