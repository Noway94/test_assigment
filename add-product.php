<?php
include_once 'Product.php';

include_once 'ProductFactory.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sku = $_POST['sku'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $size_mb = $_POST['size_mb'];
    $weight_kg = $_POST['weight_kg'];
    $height = $_POST['height'];
    $width = $_POST['width'];
    $length = $_POST['length'];
    $dimensions = $height . 'x' . $width . 'x' . $length;

    // Check if any of the required fields are empty or equal to 0
    if (empty($sku) || empty($name) || empty($price) || $price == 0 || empty($type) || 
        ($type == 'DVD' && (empty($size_mb) || $size_mb == 0)) || 
        ($type == 'Book' && (empty($weight_kg) || $weight_kg == 0)) || 
        ($type == 'Furniture' && (empty($height) || $height == 0 || empty($width) || $width == 0 || empty($length) || $length == 0))) {
        echo "All fields are required and cannot be zero.";
    } else {
        $product = ProductFactory::createProduct([
            'sku' => $sku,
            'name' => $name,
            'price' => $price,
            'type' => $type,
            'size_mb' => $size_mb,
            'weight_kg' => $weight_kg,
            'dimensions' => $dimensions
        ]);

        if ($product && $product->save()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error adding product.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="style-add-product.css">
</head>
<body>
    <div class="container">
        <h1>Add Product</h1>
        <hr>
        <form id="product_form" method="post" action="add-product.php">
            <div class="groups_card">
                <div class="fixed_group">
                    <div class="form-group">
                        <label for="sku">SKU:</label>
                        <input type="text" id="sku" name="sku" required>
                    </div>

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="price">Price ($):</label>
                        <input type="number" step="0.01" id="price" min='1' name="price" required>
                    </div>

                    <div class="form-group">
                        <label for="productType">Type:</label>
                        <select id="productType" name="type" required onchange="showAttributeField()">
                            <option value="">Type Switcher</option>
                            <option value="DVD">DVD</option>
                            <option value="Furniture">Furniture</option>
                            <option value="Book">Book</option>
                        </select>
                    </div>
                </div>
                <div class="just_space"></div>
                <div class="size_weight_dimensions">
                    <div class="form-group" id="DVD" style="display: none;">
                        <?php include('components/size_mb.php')?>
                    </div>
                    <div class="form-group" id="Furniture" style="display: none;">
                        <?php include('components/dimensions.php')?>
                    </div>
                    <div class="form-group" id="Book" style="display: none;">
                        <?php include('components/weight.php')?>
                    </div>
                </div>
                <div class="btns_">
                    <button type="submit">Save</button>
                    <button type="button" onclick="window.location.href='index.php'">Cancel</button>
                </div>
            </div>
        </form>
        <div id="notification" style="color: red; display: none;"></div>
    </div>

    <?php include('components/footer.php') ?>
    <script src="addProducts.js"></script>
</body>
</html>
