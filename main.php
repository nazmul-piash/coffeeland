<?php
require 'config/config.php';
require 'interfaces/IDataReader.php';
require 'interfaces/IDataWriter.php';

$config = include('config/config.php');

$logfile = 'error.log';

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
            if ($conn->connect_error) {
                throw new Exception("MySQL Connection failed: " . $conn->connect_error);
            }
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


function logError($message) {
    global $logFile;
    error_log($message . "\n", 3, $logFile);
}

function main() {
    global $config;

    try {
        $reader = createReader($config);
        $writer = createWriter($config);

        $data = $reader->readData();
        foreach ($data as $item) {
            try {
                $writer->writeData($item);
            } catch (Exception $e) {
                // Log the error
                $errorMessage = 'Failed to write data to database: ' . $e->getMessage();
                logError($errorMessage);
                throw new Exception($errorMessage);
            }
        }

        echo "Data processed successfully!";
    } catch (Exception $e) {
        $errorMessage = 'Error: ' . $e->getMessage();
        echo $errorMessage; // Display error message 
        logError($errorMessage); // Log error message to file
    }
}


main();
