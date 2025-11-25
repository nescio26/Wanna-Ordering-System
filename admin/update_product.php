<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($_SESSION['admin_id'])) {
   header('location:admin_login.php');
   exit();
}

$admin_id = $_SESSION['admin_id'];

if (isset($_POST['update'])) {

   $pid = $_POST['product_id'];
   $name = $_POST['name'];
   $price = $_POST['price'];
   $category = $_POST['category'];

   $update_product_query = "UPDATE `products` SET name = '$name', category = '$category', price = '$price' WHERE product_id = '$pid'";
   mysqli_query($conn, $update_product_query);

   $message[] = 'Product updated!';

   $old_image = $_POST['old_image'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

   if (!empty($image)) {
      if ($image_size > 2000000) {
         $message[] = 'Image size is too large!';
      } else {
         $update_image_query = "UPDATE `products` SET image = '$image' WHERE product_id = '$pid'";
         mysqli_query($conn, $update_image_query);
         move_uploaded_file($image_tmp_name, $image_folder);
         unlink('../uploaded_img/'.$old_image);
         $message[] = 'Image updated!';
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Product</title>
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

<section class="update-product">

   <h1 class="heading">Update Product</h1>

   <?php
      $update_id = $_GET['update'];
      $show_products_query = "SELECT * FROM `products` WHERE product_id = '$update_id'";
      $result = mysqli_query($conn, $show_products_query);
      if (mysqli_num_rows($result) > 0) {
         while ($fetch_products = mysqli_fetch_assoc($result)) {
   ?>
   <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="product_id" value="<?= $fetch_products['product_id']; ?>">
      <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
      <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <span>Update Name</span>
      <input type="text" required placeholder="Enter product name" name="name" maxlength="100" class="box" value="<?= $fetch_products['name']; ?>">
      <span>Update Price</span>
      <input type="number" min="0" max="9999999999" required placeholder="Enter product price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box" value="<?= $fetch_products['price']; ?>">
      <span>Update Category</span>
      <select name="category" class="box" required>
         <option selected value="<?= $fetch_products['category']; ?>"><?= $fetch_products['category']; ?></option>
         <option value="Malaysian">Malaysian</option>
         <option value="Western">Western</option>
         <option value="Drinks">Drinks</option>
         <option value="Desserts">Desserts</option>
      </select>
      <span>Update Image</span>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
      <div class="flex-btn">
         <input type="submit" value="Update" class="btn" name="update">
         <a href="products.php" class="option-btn">Go Back</a>
      </div>
   </form>
   <?php
         }
      } else {
         echo '<p class="empty">No products found!</p>';
      }
   ?>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>
