<?php
require_once 'interfaces/IDataWriter.php';

class SQLiteWriter implements IDataWriter {
    private $conn;

    public function __construct($sqliteFilePath) {
        $this->conn = new SQLite3($sqliteFilePath);
    }

    public function writeData($data) {
        $stmt = $this->conn->prepare("INSERT INTO coffee (
            entity_id, category_name, sku, name, shortdesc, price, link, image, brand, rating,
            caffeine_type, count, flavored, seasonal, instock, facebook, iskcup
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bindValue(1, $data['entity_id'], SQLITE3_INTEGER);
        $stmt->bindValue(2, $data['category_name'], SQLITE3_TEXT);
        $stmt->bindValue(3, $data['sku'], SQLITE3_TEXT);
        $stmt->bindValue(4, $data['name'], SQLITE3_TEXT);
        $stmt->bindValue(5, $data['shortdesc'], SQLITE3_TEXT);
        $stmt->bindValue(6, $data['price'], SQLITE3_FLOAT);
        $stmt->bindValue(7, $data['link'], SQLITE3_TEXT);
        $stmt->bindValue(8, $data['image'], SQLITE3_TEXT);
        $stmt->bindValue(9, $data['brand'], SQLITE3_TEXT);
        $stmt->bindValue(10, $data['rating'], SQLITE3_INTEGER);
        $stmt->bindValue(11, $data['caffeine_type'], SQLITE3_TEXT);
        $stmt->bindValue(12, $data['count'], SQLITE3_INTEGER);
        $stmt->bindValue(13, $data['flavored'], SQLITE3_INTEGER);
        $stmt->bindValue(14, $data['seasonal'], SQLITE3_INTEGER);
        $stmt->bindValue(15, $data['instock'], SQLITE3_INTEGER);
        $stmt->bindValue(16, $data['facebook'], SQLITE3_INTEGER);
        $stmt->bindValue(17, $data['iskcup'], SQLITE3_INTEGER);

        $stmt->execute();
    }

    public function __destruct() {
        $this->conn->close();
    }
}
