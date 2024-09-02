<?php
include_once 'db.php';
include_once 'Product.php';
include_once 'ProductFactory.php';

$database = new Database();
$conn = $database->getConnection();

$query = "SELECT * FROM products";
$stmt = $conn->prepare($query);
$stmt->execute();

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
$productObjects = array_map('ProductFactory::createProduct', $products);
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
            <?php foreach ($productObjects as $product): ?>
                <div class="product-card">
                    <input type="checkbox" class="delete-checkbox">
                    <div class="product-details">
                        <span class="product-sku"><?php echo htmlspecialchars($product->getSku()); ?></span>
                        <span class="product-name"><?php echo htmlspecialchars($product->getName()); ?></span>
                        <span class="product-price">$<?php echo htmlspecialchars($product->getPrice()); ?></span>
                        <span class="product-attribute"><?php echo htmlspecialchars($product->getAttribute()); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include('components/footer.php') ?>

    <script src="script.js"></script>
</body>
</html>
