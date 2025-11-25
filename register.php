<?php

include 'components/connect.php';
session_start();

if (isset($_POST['submit'])) {
   $name = trim($_POST['name']);
   $email = trim($_POST['email']);
   $number = trim($_POST['number']);
   $pass = $_POST['pass'];
   $cpass = $_POST['cpass'];

   if ($pass !== $cpass) {
      echo "<script>alert('Passwords do not match!'); window.location.href='register.php';</script>";
      exit();
   }

   $check_query = mysqli_prepare($conn, "SELECT user_id FROM `users` WHERE email = ? OR number = ?");
   mysqli_stmt_bind_param($check_query, "ss", $email, $number);
   mysqli_stmt_execute($check_query);
   mysqli_stmt_store_result($check_query);

   if (mysqli_stmt_num_rows($check_query) > 0) {
      echo "<script>alert('Email or phone number already exists!'); window.location.href='register.php';</script>";
      exit();
   }

   $insert_query = mysqli_prepare($conn, "INSERT INTO `users` (name, email, number, password) VALUES (?, ?, ?, ?)");
   mysqli_stmt_bind_param($insert_query, "ssss", $name, $email, $number, $pass);
   $insert_success = mysqli_stmt_execute($insert_query);

   if ($insert_success) {
      $user_id = mysqli_insert_id($conn);
      $_SESSION['user_id'] = $user_id;

      echo "<script>
               alert('You have successfully registered!');
               window.location.href = 'home.php';
            </script>";
      exit();
   } else {
      echo "<script>alert('Registration failed! Please try again.'); window.location.href='register.php';</script>";
   }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="header">
   <section class="flex">
      <a href="home.php" class="logo">Wanna Bistro 🍽️ </a>
      <nav class="navbar">
         <a href="home.php">Home</a>
         <a href="menu.php">Menu</a>
         <a href="orders.php">Orders</a>
         <a href="about.php">About Us</a>
         <a href="contact.php">Contact</a>
      </nav>
   </section>
</header>

<section class="form-container">
   <form action="" method="post">
      <h3>Register Now</h3>

      <input type="text" name="name" required placeholder="Enter Your Name" class="box" maxlength="50">
      <input type="email" name="email" required placeholder="Enter Your Email" class="box" maxlength="50">
      <input type="number" name="number" required placeholder="Enter Your Phone Number" class="box" min="0" max="9999999999" maxlength="10">
      <input type="password" name="pass" required placeholder="Enter Your Password" class="box" maxlength="50">
      <input type="password" name="cpass" required placeholder="Confirm Your Password" class="box" maxlength="50">
      <input type="submit" value="Register Now" name="submit" class="btn">

      <p>Already have an account? <a href="login.php">Login Now</a></p>
   </form>

   <?php if (isset($message)) { echo "<p class='error'>$message</p>"; } ?>

</section>

<script src="js/script.js"></script>

</body>
</html>
