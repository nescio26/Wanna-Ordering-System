   <?php

   include 'components/connect.php';

   session_start();

   if(isset($_SESSION['user_id'])){
      $user_id = $_SESSION['user_id'];
   }else{
      $user_id = '';
      header('location:home.php');
   };

   ?>

   <!DOCTYPE html>
   <html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>profile</title>

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
               if(mysqli_num_rows($select_profile_result) > 0){
                  $fetch_profile = mysqli_fetch_assoc($select_profile_result);
            ?>
            <p class="name"><?= $fetch_profile['name']; ?></p>
            <div class="flex">
               <a href="profile.php" class="btn">profile</a>
               <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
            </div>
         
            <?php
               }else{
            ?>
               <p class="name">please login first!</p>
               <a href="login.php" class="btn">login</a>
            <?php
            }
            ?>
         </div>

      </section>

   </header>


   <section class="user-details">

      <div class="user">
         <?php
            
         ?>
         <img src="images/boy.png" alt="">
         <p><i class="fas fa-user"></i><span><span><?= $fetch_profile['name']; ?></span></span></p>
         <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number']; ?></span></p>
         <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email']; ?></span></p>
         <a href="update_profile.php" class="btn">update info</a>
         <p class="address"><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['address'] == ''){echo 'please enter your address';}else{echo $fetch_profile['address'];} ?></span></p>
         <a href="update_address.php" class="btn">update address</a>
      </div>

   </section>

   <script src="js/script.js"></script>

   </body>
   </html>
