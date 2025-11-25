<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:home.php');
    exit();
}

if (isset($_POST['submit'])) {
    // Collect and sanitize inputs
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];

    // Update name if provided
    if (!empty($name)) {
        $update_name = "UPDATE `users` SET name = '$name' WHERE user_id = '$user_id'";
        mysqli_query($conn, $update_name);
    }

    if (!empty($email)) {
        $select_email = "SELECT * FROM `users` WHERE email = '$email'";
        $result_email = mysqli_query($conn, $select_email);
    }

    if (!empty($number)) {
        $select_number = "SELECT * FROM `users` WHERE number = '$number'";
        $result_number = mysqli_query($conn, $select_number);
        if (mysqli_num_rows($result_number) > 0) {
            echo "<script>alert('Phone number already taken!');</script>";
        } else {
            $update_number = "UPDATE `users` SET number = '$number' WHERE user_id = '$user_id'";
            mysqli_query($conn, $update_number);
        }
    }

    $select_prev_pass = "SELECT password FROM `users` WHERE user_id = '$user_id'";
    $result_prev_pass = mysqli_query($conn, $select_prev_pass);
    $fetch_prev_pass = mysqli_fetch_assoc($result_prev_pass);
    $prev_pass = $fetch_prev_pass['password'];

    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];

    if (!empty($old_pass)) {
        if ($old_pass != $prev_pass) {
            echo "<script>alert('Old password does not match!');</script>";
        } elseif ($new_pass != $confirm_pass) {
            echo "<script>alert('Confirm password does not match!');</script>";
        } else {
            if (!empty($new_pass)) {
                $update_pass = "UPDATE `users` SET password = '$new_pass' WHERE user_id = '$user_id'";
                mysqli_query($conn, $update_pass);
                echo "<script>alert('Password updated successfully!');</script>";
            } else {
                echo "<script>alert('Please enter a new password!');</script>";
            }
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
   <title>Update Profile</title>
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

    
<header class="header">

   <section class="flex">

      <a href="home.php" class="logo">Wanna Bistro 🍽️ </a>

      <nav class="navbar">
         <a href="home.php">Home</a>
         <div class="dropdown">
            <a href="menu.php" class="menu-btn">Menu</a>
            <div class="dropdown-content">
               <a href="category.php?category=malaysian">Malaysian</a>
               <a href="category.php?category=western">Western</a>
               <a href="category.php?category=drinks">Drinks</a>
               <a href="category.php?category=desserts">Desserts</a>
            </div>
         </div>         
         <a href="orders.php">Orders</a>
         <a href="about.php">About Us</a>
         <a href="contact.php">Contact</a>
      </nav>

      <div class="icons">
         <?php
            $count_cart_items_query = "SELECT * FROM `cart` WHERE user_id = '$user_id'";
            $count_cart_items_result = mysqli_query($conn, $count_cart_items_query);
            $total_cart_items = mysqli_num_rows($count_cart_items_result);
         ?>
         <a href="search.php"><i class="fas fa-search"></i></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile_query = "SELECT * FROM `users` WHERE user_id = '$user_id'";
            $select_profile_result = mysqli_query($conn, $select_profile_query);
            if (mysqli_num_rows($select_profile_result) > 0) {
                $fetch_profile = mysqli_fetch_assoc($select_profile_result);
         ?>
         <p class="name"><?= $fetch_profile['name']; ?></p>
         <div class="flex">
            <a href="profile.php" class="btn">profile</a>
            <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
         </div>
      
         <?php
            } else {
         ?>
            <p class="name">Login First!</p>
            <a href="login.php" class="btn">login</a>
         <?php
         }
         ?>
      </div>

   </section>

</header>

    <section class="form-container update-form">
        <form action="" method="post">
            <h3>Update Profile</h3>
            <input type="text" name="name" placeholder="Name" class="box" maxlength="50">
            <input type="email" name="email" placeholder="Email" class="box" maxlength="50">
            <input type="number" name="number" placeholder="Phone Number" class="box" maxlength="10">
            <input type="password" name="old_pass" placeholder="Enter your old password" class="box" maxlength="50">
            <input type="password" name="new_pass" placeholder="Enter your new password" class="box" maxlength="50">
            <input type="password" name="confirm_pass" placeholder="Confirm your new password" class="box" maxlength="50">
            <input type="submit" value="Update Now" name="submit" class="btn">
        </form>
    </section>


    <footer class="footer">

   <div class="footer-credit">
      &copy; <span>Syahmi</span> | All Rights Reserved!
   </div>

</footer>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>
</body>
</html>
