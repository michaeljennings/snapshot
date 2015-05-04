<?php namespace Michaeljennings\Snapshot\Store\PDO; 

use PDO;
use DateTime;
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

        $this->pdo = $this->createConnection($config['store']['pdo']);
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

        list($fields, $placeholder) = $this->prepareFieldsForStatement($input);

        $this->pdo->prepare("INSERT INTO snapshots ($fields) VALUES ($placeholder)")->execute(array_values($input));

        return $this->find($this->pdo->lastInsertId());
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

        list($fields, $placeholder) = $this->prepareFieldsForStatement($input);

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

    /**
     * Find the items belonging to a snapshot.
     *
     * @param $snapshotId
     * @return array
     */
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

    /**
     * Prepare an array of key value pairs for a prepared PDO statement.
     *
     * @param array $input
     * @return array
     */
    protected function prepareFieldsForStatement(array $input)
    {
        $keys = array_keys($input);
        $fields = '`' . implode('`, `', $keys) . '`';

        $placeholder = substr(str_repeat('?,', count($keys)), 0, -1);
        return array($fields, $placeholder);
    }

    /**
     * Create a PDO connection.
     *
     * @param array $config
     * @return PDO
     */
    protected function createConnection(array $config)
    {
        $method = 'create' . ucfirst($config['connection']) . 'Connection';

        if (method_exists($this, $method)) {
            return $this->$method($config);
        }

        return $this->createDefaultConnection($config);
    }

    /**
     * Create an SQLite PDO connection.
     *
     * @param array $config
     * @return PDO
     */
    protected function createSqliteConnection(array $config)
    {
        $driver = $config['connection'];
        $config = $config['connections'][$driver];

        $pdo = new PDO("sqlite:{$config['database']}");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    /**
     * Create a default PDO connection.
     *
     * @param array $config
     * @return PDO
     */
    protected function createDefaultConnection(array $config)
    {
        $driver = $config['connection'];
        $config = $config['connections'][$driver];

        $pdo = new PDO("{$driver}:host={$config['host']};dbname={$config['db']}", $config['username'], $config['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

}