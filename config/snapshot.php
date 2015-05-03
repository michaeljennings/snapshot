<?php

return [

    /**
     * -------------------------------------------------------------------------
     *  Store
     * -------------------------------------------------------------------------
     *
     * Set the class to use to store the snapshots.
     *
     * Supported: Michaeljennings\\Snapshot\\Store\\Eloquent\\Store
     *
     */
    'store' => 'Michaeljennings\\Snapshot\\Store\\Eloquent\\Store',

    /**
     * -------------------------------------------------------------------------
     *  Renderer
     * -------------------------------------------------------------------------
     *
     * Set the class to use to render the snapshots.
     *
     * Supported: Michaeljennings\\Snapshot\\Renderers\\Illuminate
     *            Michaeljennings\\Snapshot\\Renderers\\Native
     *
     */
    'renderer' => 'Michaeljennings\\Snapshot\\Renderers\\Illuminate',

    /**
     * -------------------------------------------------------------------------
     *  View
     * -------------------------------------------------------------------------
     *
     * Set the view to use to render the snapshots.
     */
    'view' => 'snapshot::bootstrap.snapshot'

];