<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($_SESSION['admin_id'])) {
   header('location:admin_login.php');
   exit();
}

$admin_id = $_SESSION['admin_id'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Dashboard</title>
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
            // Query to get admin profile info using mysqli
            $select_profile_query = "SELECT * FROM `admin` WHERE admin_id = '$admin_id'";
            $result = mysqli_query($conn, $select_profile_query);
            $fetch_profile = mysqli_fetch_assoc($result);
         ?>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="update_profile.php" class="btn">update profile</a>
         <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
      </div>

   </section>
</header>

<section class="dashboard">

   <h1 class="heading">Dashboard</h1>

   <div class="box-container">

   <div class="box">
      <?php
         $total_pendings = 0;
         // Query to fetch pending orders
         $select_pendings_query = "SELECT * FROM `orders` WHERE payment_status = 'pending'";
         $result = mysqli_query($conn, $select_pendings_query);
         while ($fetch_pendings = mysqli_fetch_assoc($result)) {
            $total_pendings += $fetch_pendings['total_price'];
         }
      ?>
      <h3><span>RM</span><?= $total_pendings; ?></h3>
      <p>Total Pending Orders</p>
      <a href="placed_orders.php" class="btn">See Orders</a>
   </div>

   <div class="box">
      <?php
         $total_completes = 0;
         // Query to fetch completed orders
         $select_completes_query = "SELECT * FROM `orders` WHERE payment_status = 'completed'";
         $result = mysqli_query($conn, $select_completes_query);
         while ($fetch_completes = mysqli_fetch_assoc($result)) {
            $total_completes += $fetch_completes['total_price'];
         }
      ?>
      <h3><span>RM</span><?= $total_completes; ?></h3>
      <p>Total Completed Orders</p>
      <a href="placed_orders.php" class="btn">See Orders</a>
   </div>

   <div class="box">
      <?php
         // Query to count total orders
         $select_orders_query = "SELECT * FROM `orders`";
         $result = mysqli_query($conn, $select_orders_query);
         $numbers_of_orders = mysqli_num_rows($result);
      ?>
      <h3><?= $numbers_of_orders; ?></h3>
      <p>Total Orders</p>
      <a href="placed_orders.php" class="btn">See Orders</a>
   </div>

   <div class="box">
      <?php
         // Query to count total products
         $select_products_query = "SELECT * FROM `products`";
         $result = mysqli_query($conn, $select_products_query);
         $numbers_of_products = mysqli_num_rows($result);
      ?>
      <h3><?= $numbers_of_products; ?></h3>
      <p>Products Added</p>
      <a href="products.php" class="btn">See Products</a>
   </div>

   <div class="box">
      <?php
         // Query to count total users
         $select_users_query = "SELECT * FROM `users`";
         $result = mysqli_query($conn, $select_users_query);
         $numbers_of_users = mysqli_num_rows($result);
      ?>
      <h3><?= $numbers_of_users; ?></h3>
      <p>Users Accounts</p>
      <a href="users_accounts.php" class="btn">See Users</a>
   </div>

   <div class="box">
      <?php
         // Query to count total admins
         $select_admins_query = "SELECT * FROM `admin`";
         $result = mysqli_query($conn, $select_admins_query);
         $numbers_of_admins = mysqli_num_rows($result);
      ?>
      <h3><?= $numbers_of_admins; ?></h3>
      <p>Admins</p>
      <a href="admin_accounts.php" class="btn">See Admins</a>
   </div>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>
