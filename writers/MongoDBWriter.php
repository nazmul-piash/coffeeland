<?php
require __DIR__ . 'interfaces/IDataWriter.php';

class MongoDBWriter implements IDataWriter {
    private $client;
    private $collection;

    public function __construct($mongoConfig) {
        $this->client = new MongoDB\Client($mongoConfig['uri']);
        $this->collection = $this->client->{$mongoConfig['dbname']}->fee;
    }

    public function writeData($data) {
        $this->collection->insertOne($data);
    }
}
