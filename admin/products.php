<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:admin_login.php');
};

if (isset($_POST['add_product'])) {   // Insert new products
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;

    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
    $select_products->execute([$name]);

    if ($select_products->rowCount() > 0) {
        $message[] = 'Product name already exists!';
    } else {
        if ($image_size > 2000000) {
            $message[] = 'Image size is too large!';
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);

            $insert_product = $conn->prepare("INSERT INTO `products`(name, category, price, image) VALUES(?,?,?,?)");
            $insert_product->execute([$name, $category, $price, $image]);

            $message[] = 'New product added!';
        }
    }
}

if (isset($_GET['delete'])) {   // Delete products
    $delete_id = $_GET['delete'];
    $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploaded_img/' . $fetch_delete_image['image']);

    $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $delete_product->execute([$delete_id]);

   

    header('location:products.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/admin_style.css">
    <style>
        .box {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 20px;
            margin-bottom: 10px;
        }
        .btn {
            background-color: #5A34F3;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #4a29d2;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
    </style>
</head>
<body>

<div class="container">
    <?php include '../components/admin_header.php'; ?>

    <!-- Add Product Section -->
    <section class="add-products">
        <form action="" method="POST" enctype="multipart/form-data">
            <h3>Add Product</h3>

            <label for="name">Product Name:</label>
            <input type="text" id="name" required placeholder="Enter product name" name="name" maxlength="100" class="box">

            <label for="price">Product Price:</label>
            <input type="number" id="price" min="0" max="9999999999" required placeholder="Enter product price" name="price" class="box">

            <label for="category">Category:</label>
            <select name="category" id="category" class="box" required>
                <option value="" disabled selected>Select category --</option>
                <option value="Mens">Mens</option>
                <option value="Womens">Womens</option>
                <option value="Kids">Kids</option>
            </select>

            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>

            <input type="submit" value="Add Product" name="add_product" class="btn">
        </form>
    </section>

    <!-- Show Products Section -->
    <section class="show-products" style="padding-top: 0;">
        <div class="box-container">
            <?php
            $show_products = $conn->prepare("SELECT * FROM `products`");
            $show_products->execute();
            if ($show_products->rowCount() > 0) {
                while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {  
            ?>
            <div class="box">
                <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                <div class="flex">
                    <div class="price"><span>$</span><?= $fetch_products['price']; ?><span>/-</span></div>
                    <div class="category"><?= $fetch_products['category']; ?></div>
                </div>
                <div class="name"><?= $fetch_products['name']; ?></div>
                <div class="flex-btn">
                    <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Update</a>
                    <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
                </div>
            </div>
            <?php
                }
            } else {
                echo '<p class="empty">No products added yet!</p>';
            }
            ?>
        </div>
    </section>
</div>

<!-- Custom JS -->
<script src="../js/admin_script.js"></script>

</body>

</html>
