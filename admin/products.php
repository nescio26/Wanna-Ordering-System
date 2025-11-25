<?php

include '../components/connect.php';

session_start();

if (!isset($_SESSION['admin_id'])) {
   header('location:admin_login.php');
   exit();
}

$admin_id = $_SESSION['admin_id'];

if (isset($_POST['add_product'])) {

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $category = mysqli_real_escape_string($conn, $_POST['category']);

   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/' . $image;

   $select_products_query = "SELECT * FROM `products` WHERE name = '$name'";
   $result = mysqli_query($conn, $select_products_query);

   if (mysqli_num_rows($result) > 0) {
      echo "<script>alert('Product name already exists!'); window.location.href='products.php';</script>";
   } else {
      if ($image_size > 2000000) {
         echo "<script>alert('Image size is too large!'); window.location.href='products.php';</script>";
      } else {
         move_uploaded_file($image_tmp_name, $image_folder);

         $insert_product_query = "INSERT INTO `products` (name, category, price, image) 
         VALUES ('$name', '$category', '$price', '$image')";

         if (mysqli_query($conn, $insert_product_query)) {
            echo "<script>alert('New product added successfully!'); window.location.href='products.php';</script>";
         } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
         }

               }
   }
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];

   $delete_product_image_query = "SELECT image FROM `products` WHERE product_id = '$delete_id'";
   $result = mysqli_query($conn, $delete_product_image_query);
   $fetch_delete_image = mysqli_fetch_assoc($result);

   if (file_exists('../uploaded_img/' . $fetch_delete_image['image'])) {
      unlink('../uploaded_img/' . $fetch_delete_image['image']);
   }

   $delete_product_query = "DELETE FROM `products` WHERE product_id = '$delete_id'";
   mysqli_query($conn, $delete_product_query);

   $delete_cart_query = "DELETE FROM `cart` WHERE product_id = '$delete_id'";
   mysqli_query($conn, $delete_cart_query);

   echo "<script>alert('Product deleted successfully!'); window.location.href='products.php';</script>";
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<header class="header">

   <section class="flex">

      <a href="dashboard.php" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
         <a href="dashboard.php">Home</a>
         <a href="products.php">Products</a>
         <a href="placed_orders.php">Orders</a>
         <a href="admin_accounts.php">Admins</a>
         <a href="users_accounts.php">Users</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile_query = "SELECT * FROM `admin` WHERE admin_id = '$admin_id'";
            $result = mysqli_query($conn, $select_profile_query);
            $fetch_profile = mysqli_fetch_assoc($result);
         ?>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="update_profile.php" class="btn">Update Profile</a>
         <a href="../components/admin_logout.php" onclick="return confirm('Logout from this website?');" class="delete-btn">Logout</a>
      </div>

   </section>

</header>

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Add Product</h3>
      <input type="text" required placeholder="Enter product name" name="name" maxlength="100" class="box">
      <input type="number" min="0" max="9999999999" required placeholder="Enter product price" name="price" class="box">
      <select name="category" class="box" required>
         <option value="" disabled selected>Select category --</option>
         <option value="Malaysian">Malaysian</option>
         <option value="Western">Western</option>
         <option value="Drinks">Drinks</option>
         <option value="Desserts">Desserts</option>
      </select>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <input type="submit" value="Add Product" name="add_product" class="btn">
   </form>

</section>

<!-- Show Products Section -->
<section class="show-products" style="padding-top: 0;">

   <div class="box-container">

   <?php
      $show_products_query = "SELECT * FROM `products`";
      $result = mysqli_query($conn, $show_products_query);
      if (mysqli_num_rows($result) > 0) {
         while ($fetch_products = mysqli_fetch_assoc($result)) {
   ?>
   <div class="box">
      <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <div class="flex">
         <div class="price"><span>RM</span><?= $fetch_products['price']; ?><span></span></div>
         <div class="category"><?= $fetch_products['category']; ?></div>
      </div>
      <div class="name"><?= $fetch_products['name']; ?></div>
      <div class="flex-btn">
         <a href="update_product.php?update=<?= $fetch_products['product_id']; ?>" class="option-btn">Update</a>
         <a href="products.php?delete=<?= $fetch_products['product_id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
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

<script src="../js/admin_script.js"></script>

</body>
</html>
