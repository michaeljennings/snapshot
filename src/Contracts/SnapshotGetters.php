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
     * Check if the snapshot has any post data.
     *
     * @return boolean
     */
    public function hasPost();

    /**
     * Get all get data from the snapshot.
     *
     * @return array|mixed
     */
    public function getGet();

    /**
     * Check if the snapshot has any get data.
     *
     * @return boolean
     */
    public function hasGet();

    /**
     * Get all file data from the snapshot.
     *
     * @return array|mixed
     */
    public function getFiles();

    /**
     * Check if the snapshot has any file data.
     *
     * @return mixed
     */
    public function hasFiles();

    /**
     * Get the cookie data from the snapshot.
     *
     * @return array|mixed
     */
    public function getCookies();

    /**
     * Check if the snapshot has any cookie data.
     *
     * @return boolean
     */
    public function hasCookies();

    /**
     * Get the session data from the snapshot.
     *
     * @return array|mixed
     */
    public function getSession();

    /**
     * Check if the snapshot has any session data.
     *
     * @return boolean
     */
    public function hasSession();

    /**
     * Get the environment data from the snapshot.
     *
     * @return array|mixed
     */
    public function getEnvironment();

    /**
     * Check if the snapshot has any environment data.
     *
     * @return boolean
     */
    public function hasEnvironment();

    /**
     * Get any additional data for the snapshot.
     *
     * @return array|mixed
     */
    public function getAddtionalData();

    /**
     * Check if the snapshot has any additional data.
     *
     * @return boolean
     */
    public function hasAdditionalData();

}