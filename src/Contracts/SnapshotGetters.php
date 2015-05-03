<?php namespace Michaeljennings\Snapshot\Contracts;

interface SnapshotGetters {

    /**
     * Return this id.
     *
     * @return string|integer
     */
    public function getId();

    /**
     * Get all of the snapshot's items.
     *
     * @return mixed
     */
    public function getItems();

    /**
     * Get all of the server variables at the time of the snapshot.
     *
     * @return array|mixed
     */
    public function getServer();

    /**
     * Get all post data from the snapshot.
     *
     * @return array|mixed
     */
    public function getPost();

    /**
     * Get all get data from the snapshot.
     *
     * @return array|mixed
     */
    public function getGet();

    /**
     * Get all file data from the snapshot.
     *
     * @return array|mixed
     */
    public function getFiles();

    /**
     * Get the cookie data from the snapshot.
     *
     * @return array|mixed
     */
    public function getCookies();

    /**
     * Get the session data from the snapshot.
     *
     * @return array|mixed
     */
    public function getSession();

    /**
     * Get the environment data from the snapshot.
     *
     * @return array|mixed
     */
    public function getEnvironment();

}