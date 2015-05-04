<?php namespace Michaeljennings\Snapshot\Store\Eloquent;

use Michaeljennings\Snapshot\Store\AbstractStore;

class Store extends AbstractStore {

    /**
     * Create a new snapshot.
     *
     * @param array $input
     * @return Snapshot
     */
    protected function snapshot(array $input)
    {
        $model = $this->config['store']['eloquent']['models']['snapshot'];
        $model = new $model;

        return $model->create($input);
    }

    /**
     * Create a new snapshot item.
     *
     * @param $snapshotId
     * @param array $input
     * @return Item
     */
    protected function item($snapshotId, array $input)
    {
        $model = $this->config['store']['eloquent']['models']['item'];
        $model = new $model;

        $input['snapshot_id'] = $snapshotId;

        return $model->create($input);
    }

    /**
     * Find a snapshot by its id.
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $model = $this->config['store']['eloquent']['models']['snapshot'];
        $model = new $model;

        return $model->where('id', $id)->with('items')->first();
    }

}