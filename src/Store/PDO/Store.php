<?php namespace Michaeljennings\Snapshot\Store\PDO; 

use PDO;
use DateTime;
use Michaeljennings\Snapshot\Store\PDO\Item;
use Michaeljennings\Snapshot\Store\PDO\Snapshot;
use Michaeljennings\Snapshot\Store\AbstractStore;

class Store extends AbstractStore {

    /**
     * The PDO connection.
     *
     * @var PDO
     */
    protected $pdo;

    public function __construct(array $config)
    {
        parent::__construct($config);

        $config = $config['store']['pdo']['connection'];
        $this->pdo = new PDO("mysql:host={$config['host']};dbname={$config['db']}", $config['username'], $config['password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Create a new snapshot.
     *
     * @param array $input
     * @return Snapshot
     */
    protected function snapshot(array $input)
    {
        $date = new DateTime();

        $input['created_at'] = $date->format('Y-m-d H:i:s');
        $input['updated_at'] = $date->format('Y-m-d H:i:s');

        $keys = array_keys($input);
        $fields = '`'.implode('`, `',$keys).'`';

        $placeholder = substr(str_repeat('?,', count($keys)), 0, -1);

        $this->pdo->prepare("INSERT INTO snapshots ($fields) VALUES ($placeholder)")->execute(array_values($input));

        $this->find($this->pdo->lastInsertId());
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
        $keys = array_keys($input);
        $fields = '`'.implode('`, `',$keys).'`';

        $placeholder = substr(str_repeat('?,', count($keys)), 0, -1);

        $this->pdo->prepare("INSERT INTO snapshot_items ($fields) VALUES ($placeholder)")->execute(array_values($input));
    }

    /**
     * Find a snapshot by its id.
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `snapshots` WHERE `id` = ?");
        $stmt->execute([$id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $row['items'] = $this->findSnapshotItems($id);

        return $this->makeSnapshotWrapper($row);
    }

    protected function findSnapshotItems($snapshotId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `snapshot_items` WHERE `snapshot_id` = ?");
        $stmt->execute([$snapshotId]);

        $items = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = $this->makeItemWrapper($row);
        }

        return $items;
    }

    /**
     * Return a snapshot row as an array accessible object.
     *
     * @param array $attributes
     * @return Snapshot
     */
    protected function makeSnapshotWrapper(array $attributes)
    {
        return new Snapshot($attributes);
    }

    /**
     * Return a snapshot item row as an array accessible object.
     *
     * @param array $attributes
     * @return Item
     */
    protected function makeItemWrapper(array $attributes)
    {
        return new Item($attributes);
    }

}