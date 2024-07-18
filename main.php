<?php
require __DIR__ . '/config/config.php';
require __DIR__ . '/interfaces/IDataReader.php';
require __DIR__ . '/interfaces/IDataWriter.php';

$config = include(__DIR__ . '/config/config.php');

function createReader($config) {
    if ($config['reader'] === 'XMLReader') {
        require __DIR__ . '/readers/XMLReader.php';
        return new XMLReader($config['xmlFilePath']);
    } else {
        throw new Exception("Unsupported reader: " . $config['reader']);
    }
}

function createWriter($config) {
    switch ($config['writer']) {
        case 'MySQLWriter':
            require __DIR__ . '/writers/MySQLWriter.php';
            $conn = new mysqli(
                $config['dbConfig']['servername'],
                $config['dbConfig']['username'],
                $config['dbConfig']['password'],
                $config['dbConfig']['dbname']
            );
            return new MySQLWriter($conn);
        case 'SQLiteWriter':
            require __DIR__ . '/writers/SQLiteWriter.php';
            return new SQLiteWriter($config['sqliteFilePath']);
        case 'MongoDBWriter':
            require __DIR__ . '/writers/MongoDBWriter.php';
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
