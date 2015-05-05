<?php namespace Michaeljennings\Snapshot\Store\PDO; 

use ArrayAccess;
use Michaeljennings\Snapshot\Contracts\SnapshotGetters;

class Snapshot implements SnapshotGetters, ArrayAccess {

    /**
     * The row's attributes.
     *
     * @var array
     */
    protected $attributes = [];

    public function __construct(array $attributes = array())
    {
        $this->attributes = $attributes;
    }

    /**
     * Return this id.
     *
     * @return string|integer
     */
    public function getId()
    {
        return $this->attributes['id'];
    }

    /**
     * Get all of the server variables at the time of the snapshot.
     *
     * @return array|mixed
     */
    public function getServer()
    {
        return ! is_null($this->attributes['server']) ? json_decode($this->attributes['server']) : [];
    }

    /**
     * Get all post data from the snapshot.
     *
     * @return array|mixed
     */
    public function getPost()
    {
        return ! is_null($this->attributes['post']) ? json_decode($this->attributes['post']) : [];
    }

    /**
     * Get all get data from the snapshot.
     *
     * @return array|mixed
     */
    public function getGet()
    {
        return ! is_null($this->attributes['get']) ? json_decode($this->attributes['get']) : [];
    }

    /**
     * Get all file data from the snapshot.
     *
     * @return array|mixed
     */
    public function getFiles()
    {
        return ! is_null($this->attributes['file']) ? json_decode($this->attributes['file']) : [];
    }

    /**
     * Get the cookie data from the snapshot.
     *
     * @return array|mixed
     */
    public function getCookies()
    {
        return ! is_null($this->attributes['cookies']) ? json_decode($this->attributes['cookies']) : [];
    }

    /**
     * Get the session data from the snapshot.
     *
     * @return array|mixed
     */
    public function getSession()
    {
        return ! is_null($this->attributes['session']) ? json_decode($this->attributes['session']) : [];
    }

    /**
     * Get the environment data from the snapshot.
     *
     * @return array|mixed
     */
    public function getEnvironment()
    {
        return ! is_null($this->attributes['environment']) ? json_decode($this->attributes['environment']) : [];
    }

    /**
     * Get any additional data for the snapshot.
     *
     * @return array|mixed
     */
    public function getAddtionalData()
    {
        return ! is_null($this->attributes['additional_data']) ? json_decode($this->attributes['additional_data']) : [];
    }

    /**
     * Get all of the snapshot's items.
     *
     * @return mixed
     */
    public function getItems()
    {
        return $this->attributes['items'];
    }

    /**
     * Check if the snapshot has any post data.
     *
     * @return boolean
     */
    public function hasPost()
    {
        return is_null($this->attributes['post']) ? false : true;
    }

    /**
     * Check if the snapshot has any get data.
     *
     * @return boolean
     */
    public function hasGet()
    {
        return is_null($this->attributes['get']) ? false : true;
    }

    /**
     * Check if the snapshot has any file data.
     *
     * @return mixed
     */
    public function hasFiles()
    {
        return is_null($this->attributes['files']) ? false : true;
    }

    /**
     * Check if the snapshot has any cookie data.
     *
     * @return boolean
     */
    public function hasCookies()
    {
        return is_null($this->attributes['cookies']) ? false : true;
    }

    /**
     * Check if the snapshot has any session data.
     *
     * @return boolean
     */
    public function hasSession()
    {
        return is_null($this->attributes['session']) ? false : true;
    }

    /**
     * Check if the snapshot has any environment data.
     *
     * @return boolean
     */
    public function hasEnvironment()
    {
        return is_null($this->attributes['environment']) ? false : true;
    }

    /**
     * Check if the snapshot has any additional data.
     *
     * @return boolean
     */
    public function hasAdditionalData()
    {
        return is_null($this->attributes['additional_data']) ? false : true;
    }

    /**
     * Determine if the given offset exists.
     *
     * @param  string  $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->{$offset});
    }
    /**
     * Get the value for a given offset.
     *
     * @param  string  $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->{$offset};
    }
    /**
     * Set the value at the given offset.
     *
     * @param  string  $offset
     * @param  mixed   $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->{$offset} = $value;
    }
    /**
     * Unset the value at the given offset.
     *
     * @param  string  $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->{$offset});
    }

    /**
     * Dynamically retrieve the value of an attribute.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }
    /**
     * Dynamically set the value of an attribute.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }
    /**
     * Dynamically check if an attribute is set.
     *
     * @param  string  $key
     * @return void
     */
    public function __isset($key)
    {
        return isset($this->attributes[$key]);
    }
    /**
     * Dynamically unset an attribute.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($key)
    {
        unset($this->attributes[$key]);
    }

}