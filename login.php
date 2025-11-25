<?php

include 'components/connect.php';

session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'] ; 
    $pass = $_POST['pass'] ;

    if ($email && $pass) {  
        $query = "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $row['user_id'];
            header('location:home.php');
            exit();
        } else {
            $message[] = 'Incorrect username or password!';
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
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Header Section -->
<header class="header">
   <section class="flex">
      <a href="home.php" class="logo">Wanna Bistro 🍽️</a>
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
         <a href="search.php"><i class="fas fa-search"></i></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(0)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>
      <div class="profile">
         <?php if (isset($_SESSION['user_id'])) { ?>
            <p class="name"><?= htmlspecialchars($fetch_profile['name']); ?></p>
            <a href="profile.php" class="btn">Profile</a>
            <a href="components/user_logout.php" onclick="return confirm('Logout from this website?');" class="delete-btn">Logout</a>
         <?php } else { ?>
            <p class="name">Login First</p>
            <a href="login.php" class="btn">Login</a>
         <?php } ?>
      </div>
   </section>
</header>

<!-- Login Form -->
<section class="form-container">
   <form action="" method="post">
      <h3>Login Now</h3>
      <input type="email" name="email" required placeholder="Enter Your Email" class="box">
      <input type="password" name="pass" required placeholder="Enter Your Password" class="box">
      <input type="submit" value="Login Now" name="submit" class="btn">
      <p>Don't Have An Account Yet? <a href="register.php">Register Now</a></p>
   </form>
</section>

<script src="js/script.js"></script>

</body>
</html>
