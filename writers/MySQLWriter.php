
<?php
require_once 'interfaces/IDataWriter.php';

class MySQLWriter implements IDataWriter {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;

        // Checking connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function writeData($data) {
        $stmt = $this->conn->prepare("INSERT INTO coffee (
            entity_id, category_name, sku, name, shortdesc, price, link, image, brand, rating,
            caffeine_type, count, flavored, seasonal, instock, facebook, iskcup
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("isssssssisiissiii", 
            $data['entity_id'], $data['category_name'], $data['sku'], $data['name'], $data['shortdesc'], 
            $data['price'], $data['link'], $data['image'], $data['brand'], $data['rating'], 
            $data['caffeine_type'], $data['count'], $data['flavored'], $data['seasonal'], 
            $data['instock'], $data['facebook'], $data['iskcup']
        );

        $stmt->execute();
        $stmt->close();
    }

    public function __destruct() {
        $this->conn->close();
    }
}
