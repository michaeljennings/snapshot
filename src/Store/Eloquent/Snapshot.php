<?php namespace Michaeljennings\Snapshot\Store\Eloquent; 

use Illuminate\Database\Eloquent\Model;
use Michaeljennings\Snapshot\Contracts\SnapshotGetters;

class Snapshot extends Model implements SnapshotGetters {

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
    protected $fillable = ['file', 'line', 'server', 'post', 'get', 'files', 'cookies',
        'session', 'environment'];

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
        return $this->server ? json_decode($this->server) : [];
    }

    /**
     * Get all post data from the snapshot.
     *
     * @return array|mixed
     */
    public function getPost()
    {
        return $this->post ? json_decode($this->post) : [];
    }

    /**
     * Get all get data from the snapshot.
     *
     * @return array|mixed
     */
    public function getGet()
    {
        return $this->get ? json_decode($this->get) : [];
    }

    /**
     * Get all file data from the snapshot.
     *
     * @return array|mixed
     */
    public function getFiles()
    {
        return $this->files ? json_decode($this->files) : [];
    }

    /**
     * Get the cookie data from the snapshot.
     *
     * @return array|mixed
     */
    public function getCookies()
    {
        return $this->cookies ? json_decode($this->cookies) : [];
    }

    /**
     * Get the session data from the snapshot.
     *
     * @return array|mixed
     */
    public function getSession()
    {
        return $this->session ? json_decode($this->session) : [];
    }

    /**
     * Get the environment data from the snapshot.
     *
     * @return array|mixed
     */
    public function getEnvironment()
    {
        return $this->environment ? json_decode($this->environment) : [];
    }

}