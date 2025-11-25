<?php

include '../components/connect.php';

session_start();

if (!isset($_SESSION['admin_id'])) {
   header('location:admin_login.php');
   exit();
}

$admin_id = $_SESSION['admin_id'];

if (isset($_POST['update_payment'])) {
   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   
   $update_status_query = "UPDATE `orders` SET payment_status = '$payment_status' WHERE order_id = '$order_id'";
   mysqli_query($conn, $update_status_query);
   $message[] = 'Payment status updated!';
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   
   $delete_order_query = "DELETE FROM `orders` WHERE order_id = '$delete_id'";
   mysqli_query($conn, $delete_order_query);
   header('location:placed_orders.php');
   exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Placed Orders</title>
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
            // Fetch admin profile using mysqli
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


<section class="placed-orders">

   <h1 class="heading">Placed Orders</h1>

   <div class="box-container">

   <?php
      // Fetch orders using mysqli
      $select_orders_query = "SELECT * FROM `orders`";
      $result = mysqli_query($conn, $select_orders_query);
      if (mysqli_num_rows($result) > 0) {
         while ($fetch_orders = mysqli_fetch_assoc($result)) {
   ?>
   <div class="box">
      <p>User Id : <span><?= $fetch_orders['user_id']; ?></span></p>
      <p>Placed On : <span><?= $fetch_orders['placed_on']; ?></span></p>
      <p>Name : <span><?= $fetch_orders['name']; ?></span></p>
      <p>Email : <span><?= $fetch_orders['email']; ?></span></p>
      <p>Number : <span><?= $fetch_orders['number']; ?></span></p>
      <p>Address : <span><?= $fetch_orders['address']; ?></span></p>
      <p>Total Products : <span><?= $fetch_orders['total_products']; ?></span></p>
      <p>Total Price : <span>RM<?= $fetch_orders['total_price']; ?></span></p>
      <p>Payment Method : <span><?= $fetch_orders['method']; ?></span></p>

      <form action="" method="POST">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['order_id']; ?>">
         <select name="payment_status" class="drop-down">
            <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
         </select>
         <div class="flex-btn">
            <input type="submit" value="Update" class="btn" name="update_payment">
            <a href="placed_orders.php?delete=<?= $fetch_orders['order_id']; ?>" class="delete-btn" onclick="return confirm('Delete this order?');">Delete</a>
         </div>
      </form>
   </div>
   <?php
      }
   } else {
      echo '<p class="empty">No orders placed yet!</p>';
   }
   ?>

   </div>

</section>
<script src="../js/admin_script.js"></script>
</body>
</html>
