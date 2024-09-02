<?php
class ProductFactory {
    public static function createProduct($productData) {
        switch ($productData['type']) {
            case 'DVD':
                return new DVD($productData['sku'], $productData['name'], $productData['price'], $productData['size_mb']);
            case 'Book':
                return new Book($productData['sku'], $productData['name'], $productData['price'], $productData['weight_kg']);
            case 'Furniture':
                return new Furniture($productData['sku'], $productData['name'], $productData['price'], $productData['dimensions']);
            default:
                return null;
        }
    }
}
?>
