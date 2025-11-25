<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}


include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>menu</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
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
         <?php
            // MySQLi query to count cart items
            $count_cart_items = mysqli_prepare($conn, "SELECT * FROM `cart` WHERE user_id = ?");
            mysqli_stmt_bind_param($count_cart_items, "i", $user_id);
            mysqli_stmt_execute($count_cart_items);
            $result_cart = mysqli_stmt_get_result($count_cart_items);
            $total_cart_items = mysqli_num_rows($result_cart);
         ?>
         <a href="search.php"><i class="fas fa-search"></i></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <div class="profile">
         <?php
            // MySQLi query to fetch user profile
            $select_profile = mysqli_prepare($conn, "SELECT * FROM `users` WHERE user_id = ?");
            mysqli_stmt_bind_param($select_profile, "i", $user_id);
            mysqli_stmt_execute($select_profile);
            $result_profile = mysqli_stmt_get_result($select_profile);
            if(mysqli_num_rows($result_profile) > 0){
               $fetch_profile = mysqli_fetch_assoc($result_profile);
         ?>
         <p class="name"><?= $fetch_profile['name']; ?></p>
         <div class="flex">
            <a href="profile.php" class="btn">profile</a>
            <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
         </div>
         
         <?php
            } else {
         ?>
            <p class="name">please login first!</p>
            <a href="login.php" class="btn">login</a>
         <?php
            }
         ?>
      </div>

   </section>

</header>

<div class="heading">
   <h3>our menu</h3>
   <p><a href="home.php">Home</a> <span> / Menu</span></p>
</div>

<section class="products">

   <h1 class="title">latest dishes</h1>

   <div class="box-container">

      <?php
         // MySQLi query to select products
         $select_products = mysqli_prepare($conn, "SELECT * FROM `products`");
         mysqli_stmt_execute($select_products);
         $result_products = mysqli_stmt_get_result($select_products);
         if(mysqli_num_rows($result_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($result_products)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="product_id" value="<?= $fetch_products['product_id']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
         <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
         <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
         <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
         <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
         <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
         <div class="name"><?= $fetch_products['name']; ?></div>
         <div class="flex">
            <div class="price"><span>RM</span><?= $fetch_products['price']; ?></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
         </div>
      </form>
      <?php
            }
         } else {
            echo '<p class="empty">no products added yet!</p>';
         }
      ?>

   </div>

</section>

<section class="contact">
   <div class="footer-content">
      <div class="footer-box">
         <img src="images/email-icon.png" alt="Email Icon">
         <h3>Our Email</h3>
         <p><a href="mailto:wannabistro@gmail.com">wannabistro@gmail.com</a></p>
      </div>

      <div class="footer-box">
         <img src="images/clock-icon.png" alt="Clock Icon">
         <h3>Operational Hours</h3>
         <p>12:00 PM - 10:00 PM</p>
      </div>

      <div class="footer-box">
         <img src="images/map-icon.png" alt="Map Icon">
         <h3>Our Address</h3>
         <p>Bukit Tiu, Machang</p>
      </div>

      <div class="footer-box">
         <img src="images/phone-icon.png" alt="Phone Icon">
         <h3>Contact Us</h3>
         <p><a href="tel:1234567890">123-456-7890</a></p>
      </div>
   </div>
</section>

<footer class="footer">
   <div class="footer-credit">
      &copy; <span>Syahmi</span> | All Rights Reserved!
   </div>
</footer>

<script src="js/script.js"></script>

</body>
</html>
