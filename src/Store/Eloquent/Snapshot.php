<?php

namespace Michaeljennings\Snapshot\Store\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Michaeljennings\Snapshot\Contracts\SnapshotGetters;

class Snapshot extends Model implements SnapshotGetters
{
    /**
     * The database table to be used by the model.
     *
     * @var string
     */
    protected $table = 'snapshots';

    /**
     * The fillable properties for the model.
     *
     * @var array
     */
    protected $fillable = [
        'file',
        'line',
        'server',
        'post',
        'get',
        'files',
        'cookies',
        'session',
        'environment',
        'additional_data',
        'message',
        'code'
    ];

    /**
     * The snapshot items relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('Michaeljennings\Snapshot\Store\Eloquent\Item');
    }

    /**
     * Return this id.
     *
     * @return string|integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get all of the snapshot's items.
     *
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Get all of the server variables at the time of the snapshot.
     *
     * @return array|mixed
     */
    public function getServer()
    {
        return $this->server ? json_decode($this->server, true) : [];
    }

    /**
     * Get all post data from the snapshot.
     *
     * @return array|mixed
     */
    public function getPost()
    {
        return $this->post ? json_decode($this->post, true) : [];
    }

    /**
     * Get all get data from the snapshot.
     *
     * @return array|mixed
     */
    public function getGet()
    {
        return $this->get ? json_decode($this->get, true) : [];
    }

    /**
     * Get all file data from the snapshot.
     *
     * @return array|mixed
     */
    public function getFiles()
    {
        return $this->files ? json_decode($this->files, true) : [];
    }

    /**
     * Get the cookie data from the snapshot.
     *
     * @return array|mixed
     */
    public function getCookies()
    {
        return $this->cookies ? json_decode($this->cookies, true) : [];
    }

    /**
     * Get the session data from the snapshot.
     *
     * @return array|mixed
     */
    public function getSession()
    {
        return $this->session ? json_decode($this->session, true) : [];
    }

    /**
     * Get the environment data from the snapshot.
     *
     * @return array|mixed
     */
    public function getEnvironment()
    {
        return $this->environment ? json_decode($this->environment, true) : [];
    }

    /**
     * Get any additional data for the snapshot.
     *
     * @return array|mixed
     */
    public function getAdditionalData()
    {
        return $this->additional_data ? json_decode($this->additional_data, true) : [];
    }

    /**
     * Get a message for the snapshot.
     *
     * @return array|mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get a code for the snapshot.
     *
     * @return array|mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Check if the snapshot has any post data.
     *
     * @return boolean
     */
    public function hasPost()
    {
        return is_null($this->post) ? false : true;
    }

    /**
     * Check if the snapshot has any get data.
     *
     * @return boolean
     */
    public function hasGet()
    {
        return is_null($this->get) ? false : true;
    }

    /**
     * Check if the snapshot has any file data.
     *
     * @return mixed
     */
    public function hasFiles()
    {
        return is_null($this->files) ? false : true;
    }

    /**
     * Check if the snapshot has any cookie data.
     *
     * @return boolean
     */
    public function hasCookies()
    {
        return is_null($this->cookies) ? false : true;
    }

    /**
     * Check if the snapshot has any session data.
     *
     * @return boolean
     */
    public function hasSession()
    {
        return is_null($this->session) ? false : true;
    }

    /**
     * Check if the snapshot has any environment data.
     *
     * @return boolean
     */
    public function hasEnvironment()
    {
        return is_null($this->environment) ? false : true;
    }

    /**
     * Check if the snapshot has any additional data.
     *
     * @return boolean
     */
    public function hasAdditionalData()
    {
        return ! empty($this->additional_data);
    }

    /**
     * Check if the snapshot has a message.
     *
     * @return boolean
     */
    public function hasMessage()
    {
        return is_null($this->message) ? false : true;
    }

    /**
     * Check if the snapshot has a code.
     *
     * @return boolean
     */
    public function hasCode()
    {
        return is_null($this->code) ? false : true;
    }
}
