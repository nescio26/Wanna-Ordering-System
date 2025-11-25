<?php

include '../components/connect.php';

session_start();


if (!isset($_SESSION['admin_id'])) {
   header('location:admin_login.php');
   exit();
}

$admin_id = $_SESSION['admin_id'];

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   
   // Delete user-related data
   $delete_users_query = "DELETE FROM `users` WHERE user_id = '$delete_id'";
   mysqli_query($conn, $delete_users_query);

   $delete_order_query = "DELETE FROM `orders` WHERE user_id = '$delete_id'";
   mysqli_query($conn, $delete_order_query);

   $delete_cart_query = "DELETE FROM `cart` WHERE user_id = '$delete_id'";
   mysqli_query($conn, $delete_cart_query);

   header('location:users_accounts.php');
   exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Users Accounts</title>
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
            // Retrieve admin profile info
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

<!-- User accounts section -->
<section class="accounts">
   <h1 class="heading">Users Account</h1>
   <div class="box-container">
   <?php
      // Select all users from the database
      $select_account_query = "SELECT * FROM `users`";
      $result = mysqli_query($conn, $select_account_query);
      if(mysqli_num_rows($result) > 0){
         while($fetch_accounts = mysqli_fetch_assoc($result)){  
   ?>
   <div class="box">
      <p>User ID: <span><?= $fetch_accounts['user_id']; ?></span></p>
      <p>Username: <span><?= $fetch_accounts['name']; ?></span></p>
      <a href="users_accounts.php?delete=<?= $fetch_accounts['user_id']; ?>" class="delete-btn" onclick="return confirm('Delete this account?');">Delete</a>
   </div>
   <?php
      }
   } else {
      echo '<p class="empty">No accounts available</p>';
   }
   ?>
   </div>
</section>

<script src="../js/admin_script.js"></script>

</body>
</html>
