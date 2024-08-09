<?php
include_once 'db.php';

$database = new Database();
$conn = $database->getConnection();

$query = "SELECT * FROM products";
$stmt = $conn->prepare($query);
$stmt->execute();

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        
         <div class="btns_">
       <button id="add-product-btn" onclick="window.location.href='add-product.php'">ADD</button> 
        <button id="mass-delete-btn">MASS DELETE</button>
        </div>
        <h1>Product List</h1>
        <hr>
        <div id="product-list">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <input type="checkbox" class="delete-checkbox">
                    <div class="product-details">
                        <span class="product-sku"><?php echo htmlspecialchars($product['sku']); ?></span>
                        <span class="product-name"><?php echo htmlspecialchars($product['name']); ?></span>
                        <span class="product-price">$<?php echo htmlspecialchars($product['price']); ?></span>
                        <span class="product-attribute">
                            <?php
                            if ($product['type'] == 'DVD') {
                                echo "Size: " . htmlspecialchars($product['size_mb']) . " MB";
                            } elseif ($product['type'] == 'Book') {
                                echo "Weight: " . htmlspecialchars($product['weight_kg']) . " Kg";
                            } elseif ($product['type'] == 'Furniture') {
                                echo "Dimensions: " . htmlspecialchars($product['dimensions']) ." CM";
                            }
                            ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include('components/footer.php') ?>


    <script src="script.js"></script>
</body>
</html>
