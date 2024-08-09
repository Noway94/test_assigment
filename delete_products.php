<?php
include_once 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$skus = $data['skus'];

if (!empty($skus)) {
    $database = new Database();
    $conn = $database->getConnection();

    $placeholders = implode(',', array_fill(0, count($skus), '?'));
    $query = "DELETE FROM products WHERE sku IN ($placeholders)";
    $stmt = $conn->prepare($query);

    if ($stmt->execute($skus)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
