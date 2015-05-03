<?php namespace Michaeljennings\Snapshot\Store\Eloquent; 

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

    /**
     * The database table to be used by the model.
     *
     * @var string
     */
    protected $table = 'snapshot_items';

    /**
     * The fillable properties for the model.
     *
     * @var array
     */
    protected $fillable = ['snapshot_id', 'file', 'line', 'function', 'class',
        'object', 'type', 'args'];

    /**
     * Set whether the database table has timestamps.
     *
     * @var null
     */
    public $timestamps = null;

    /**
     * The item snapshot relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function snapshot()
    {
        return $this->belongsTo('Michaeljennings\Snapshot\Store\Eloquent\Snapshot');
    }

}