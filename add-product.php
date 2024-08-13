<?php
include_once 'db.php';
include_once 'Product.php';

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

       // Check if any of the required fields are empty
       if (empty($sku) || empty($name) || empty($price) || empty($type) || 
       ($type == 'DVD' && empty($size_mb)) || 
       ($type == 'Book' && empty($weight_kg)) || 
       ($type == 'Furniture' && (empty($height) || empty($width) || empty($length)))) {
       echo "All fields are required.";
   } else {
    switch ($type) {
        case 'DVD':
            $product = new DVD($sku, $name, $price, $size_mb);
            break;
        case 'Book':
            $product = new Book($sku, $name, $price, $weight_kg);
            break;
        case 'Furniture':
            $product = new Furniture($sku, $name, $price, $dimensions);
            break;
    }
   }
    if ($product->save()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error adding product.";
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
    <style>

.container {
    width: 100%;
  
    margin: 0;
    padding: 10px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

h1 {
    text-align: left;
    color: #333;
}

form {
    display: flex;
    flex-direction: column;

   
}
.groups_card{
    display: flex;
    flex-direction: column;
  
}
.fixed_group,.size_weight_dimensions{
    padding:10px;
    width:30%;
}
.size_weight_dimensions input{
    margin-top: 4px;
    width: 60%;
}
#DVD,#Book,#Furniture {
    border: 1px solid black;

    
}



.form-group {
    margin-bottom: 15px;
}

label {
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

input, select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}


button {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    margin-right: 10px;
}

button:hover {
    background-color: #0056b3;
}
.btns_{
    position: absolute;
    top: 6px;
    left: 60%;

}

@media (max-width: 600px) {
    .container {
        width: 100%;
    }
}

    </style>
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
    <script>
        function showAttributeField() {
            var type = document.getElementById('productType').value;
            document.getElementById('DVD').style.display = 'none';
            document.getElementById('Book').style.display = 'none';
            document.getElementById('Furniture').style.display = 'none';

            if (type === 'DVD') {
                document.getElementById('DVD').style.display = 'block';
            } else if (type === 'Book') {
                document.getElementById('Book').style.display = 'block';
            } else if (type === 'Furniture') {
                document.getElementById('Furniture').style.display = 'block';
            }
        }

        document.getElementById('product_form').addEventListener('submit', function(event) {
            var sku = document.getElementById('sku').value;
            var name = document.getElementById('name').value;
            var price = document.getElementById('price').value;
            var type = document.getElementById('productType').value;
            var size = document.getElementById('size').value;
            var weight = document.getElementById('weight').value;
            var height = document.getElementById('height').value;
            var width = document.getElementById('width').value;
            var length = document.getElementById('length').value;
            var notification = document.getElementById('notification');

            if (!sku || !name || !price || !type || (type === 'DVD' && !size) || (type === 'Book' && !weight) || (type === 'Furniture' && (!height || !width || !length))) {
                notification.textContent = "Please, submit required data";
                notification.style.display = 'block';
                event.preventDefault();
                return;
            }

            if (isNaN(price) || (type === 'DVD' && isNaN(size)) || (type === 'Book' && isNaN(weight)) || (type === 'Furniture' && (isNaN(height) || isNaN(width) || isNaN(length)))) {
                notification.textContent = "Please, provide the data of indicated type";
                notification.style.display = 'block';
                event.preventDefault();
                return;
            }

            notification.style.display = 'none';
        });
    </script>
</body>
</html>
