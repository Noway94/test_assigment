<?php
include_once 'db.php';

abstract class Product {
    protected $conn;
    protected $table_name = "products";
    protected $sku;
    protected $name;
    protected $price;

    public function __construct($sku, $name, $price) {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    public function getSku() {
        return $this->sku;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    abstract public function getAttribute();

    public function save() {
        $query = "INSERT INTO " . $this->table_name . " (sku, name, price, type, size_mb, weight_kg, dimensions) VALUES (:sku, :name, :price, :type, :size_mb, :weight_kg, :dimensions)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':sku', $this->sku);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':type', $this->getType());
        $stmt->bindParam(':size_mb', $this->getSizeMb());
        $stmt->bindParam(':weight_kg', $this->getWeightKg());
        $stmt->bindParam(':dimensions', $this->getDimensions());

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    protected function getType() {
        return null;
    }

    protected function getSizeMb() {
        return null;
    }

    protected function getWeightKg() {
        return null;
    }

    protected function getDimensions() {
        return null;
    }
}

class DVD extends Product {
    private $size;

    public function __construct($sku, $name, $price, $size) {
        parent::__construct($sku, $name, $price);
        $this->size = $size;
    }

    public function getAttribute() {
        return "Size: {$this->size} MB";
    }

    protected function getType() {
        return 'DVD';
    }

    protected function getSizeMb() {
        return $this->size;
    }
}

class Book extends Product {
    private $weight;

    public function __construct($sku, $name, $price, $weight) {
        parent::__construct($sku, $name, $price);
        $this->weight = $weight;
    }

    public function getAttribute() {
        return "Weight: {$this->weight} Kg";
    }

    protected function getType() {
        return 'Book';
    }

    protected function getWeightKg() {
        return $this->weight;
    }
}

class Furniture extends Product {
    private $dimensions;

    public function __construct($sku, $name, $price, $dimensions) {
        parent::__construct($sku, $name, $price);
        $this->dimensions = $dimensions;
    }

    public function getAttribute() {
        return "Dimensions: {$this->dimensions}";
    }

    protected function getType() {
        return 'Furniture';
    }

    protected function getDimensions() {
        return $this->dimensions;
    }
}
?>
