<?php

include '../components/connect.php';

session_start();

if (!isset($_SESSION['admin_id'])) {
   header('location:admin_login.php');
   exit();
}

$admin_id = $_SESSION['admin_id'];
$message = "";

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   if (!empty($name)) {
      // Check if the username already exists
      $select_name_query = "SELECT * FROM `admin` WHERE name = '$name'";
      $result = mysqli_query($conn, $select_name_query);
      if (mysqli_num_rows($result) > 0) {
         $message = "Username already taken!";
      } else {
         // Update name in the database
         $update_name_query = "UPDATE `admin` SET name = '$name' WHERE admin_id = '$admin_id'";
         mysqli_query($conn, $update_name_query);
         $message = "Username updated successfully!";
      }
   }

   // Simple password update logic (no strong hashing)
   $select_old_pass_query = "SELECT password FROM `admin` WHERE admin_id = '$admin_id'";
   $result = mysqli_query($conn, $select_old_pass_query);
   $fetch_prev_pass = mysqli_fetch_assoc($result);
   $prev_pass = $fetch_prev_pass['password'];

   // Get password inputs from the form
   $old_pass = $_POST['old_pass'];
   $new_pass = $_POST['new_pass'];
   $confirm_pass = $_POST['confirm_pass'];

   if (!empty($old_pass) && !empty($new_pass) && !empty($confirm_pass)) {
      if ($old_pass != $prev_pass) {
         $message = "Old password does not match!";
      } elseif ($new_pass != $confirm_pass) {
         $message = "Confirm password does not match!";
      } else {
         $update_pass_query = "UPDATE `admin` SET password = '$new_pass' WHERE admin_id = '$admin_id'";
         mysqli_query($conn, $update_pass_query);
         $message = "Password updated successfully!";
      }
   } elseif (!empty($new_pass) || !empty($confirm_pass) || !empty($old_pass)) {
      $message = "Please fill in all password fields!";
   }

      // Show alert message and redirect to admin_accounts.php after successful update
      if (!empty($message)) {
         echo "<script>
                  alert('$message');
                  window.location.href='admin_accounts.php';
               </script>";
         exit();
      }

   
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile Update</title>
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
   </section>
</header>

<!-- Admin profile update section -->
<section class="form-container">
   <form action="" method="POST">
      <h3>Update Profile</h3>
      <input type="text" name="name" maxlength="20" class="box" placeholder="Enter your Name">
      <input type="password" name="old_pass" maxlength="20" placeholder="Enter your Old Password" class="box">
      <input type="password" name="new_pass" maxlength="20" placeholder="Enter your New Password" class="box">
      <input type="password" name="confirm_pass" maxlength="20" placeholder="Confirm your New Password" class="box">
      <input type="submit" value="Update Now" name="submit" class="btn">
   </form>
</section>

<script src="../js/admin_script.js"></script>

</body>
</html>
