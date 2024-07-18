<?php
require 'config/config.php';
require 'interfaces/IDataReader.php';
require 'interfaces/IDataWriter.php';

$config = include('config/config.php');

function createReader($config) {
    if ($config['reader'] === 'XMLReader') {
        require 'readers/XMLReader.php';
        return new XMLRead($config['xmlFilePath']);
    } else {
        throw new Exception("Unsupported reader: " . $config['reader']);
    }
}

function createWriter($config) {
    switch ($config['writer']) {
        case 'MySQLWriter':
            require 'writers/MySQLWriter.php';
            $conn = new mysqli(
                $config['dbConfig']['servername'],
                $config['dbConfig']['username'],
                $config['dbConfig']['password'],
                $config['dbConfig']['dbname']
            );
            return new MySQLWriter($conn);
        case 'SQLiteWriter':
            require 'writers/SQLiteWriter.php';
            return new SQLiteWriter($config['sqliteFilePath']);
        case 'MongoDBWriter':
            require 'writers/MongoDBWriter.php';
            return new MongoDBWriter($config['mongoConfig']);
        default:
            throw new Exception("Unsupported writer: " . $config['writer']);
    }
}

function main() {
    global $config;

    try {
        $reader = createReader($config);
        $writer = createWriter($config);

        $data = $reader->readData();
        foreach ($data as $item) {
            $writer->writeData($item);
        }

        echo "Data processed successfully!";
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

main();
