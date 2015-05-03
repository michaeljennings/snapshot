<?php namespace Michaeljennings\Snapshot;

use Michaeljennings\Snapshot\Contracts\Store;

class Snapshot {

    /**
     * An instance of a snapshot store.
     *
     * @var Store
     */
    protected $store;

	public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * Capture the current state of the application.
     */
    public function capture()
    {
        $data = [];
        $stackTrace = debug_backtrace();

        $data['snapshot'] = [
            'file' => $this->getCalledFile($stackTrace),
            'line' => $this->getCalledLine($stackTrace),
        ];

        $data['items'] = $this->transformStackTrace($stackTrace);

        $this->store->capture($data);
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

        return array_reverse($transformedStackTrace);
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