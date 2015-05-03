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
        return Snapshot::create($input);
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
        $input['snapshot_id'] = $snapshotId;

        return Item::create($input);
    }

    /**
     * Find a snapshot by its id.
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return Snapshot::where('id', $id)->with('items')->first();
    }

}