   <?php

   include 'components/connect.php';

   session_start();

   if (isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];
   } else {
      header('location:home.php');
   }


   if (isset($_POST['delete'])) {
      $cart_id = $_POST['cart_id'];
      $delete_cart_item = mysqli_query($conn, "DELETE FROM `cart` WHERE cart_id = '$cart_id'");
      $message[] = 'cart item deleted!';
   }


   if (isset($_POST['delete_all'])) {
      $delete_cart_item = mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'");
      $message[] = 'deleted all from cart!';
   }


   if (isset($_POST['update_qty'])) {
      $cart_id = $_POST['cart_id'];
      $qty = $_POST['qty'];

      if (is_numeric($qty) && $qty > 0 && $qty <= 99) {
         $update_qty = mysqli_query($conn, "UPDATE `cart` SET quantity = '$qty' WHERE cart_id = '$cart_id'");
         $message[] = 'cart quantity updated';
      } else {
         $message[] = 'Invalid quantity!';
      }
   }

   $grand_total = 0;

   ?>

   <!DOCTYPE html>
   <html lang="en">

   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>cart</title>

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
                  $count_cart_items = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'");
                  $total_cart_items = mysqli_num_rows($count_cart_items);
                  ?>
                  <a href="search.php"><i class="fas fa-search"></i></a>
                  <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
                  <div id="user-btn" class="fas fa-user"></div>
                  <div id="menu-btn" class="fas fa-bars"></div>
               </div>

               <div class="profile">
                  <?php
                  $select_profile = mysqli_query($conn, "SELECT * FROM `users` WHERE user_id = '$user_id'");
                  if (mysqli_num_rows($select_profile) > 0) {
                     $fetch_profile = mysqli_fetch_assoc($select_profile);
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
         <h3>shopping cart</h3>
         <p><a href="home.php">Home</a> <span> / Cart</span></p>
      </div>

      <!-- Display cart item -->

      <section class="products">

         <h1 class="title">your cart</h1>

         <div class="box-container">

               <?php
               $grand_total = 0;
               $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'");
               if (mysqli_num_rows($select_cart) > 0) {
                  while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
               ?>
                     <form action="" method="post" class="box">
                           <input type="hidden" name="cart_id" value="<?= $fetch_cart['cart_id']; ?>">
                           <button type="submit" class="fas fa-times" name="delete" onclick="return confirm('delete this item?');"></button>
                           <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
                           <div class="name"><?= $fetch_cart['name']; ?></div>
                           <div class="flex">
                              <div class="price"><span>RM</span><?= $fetch_cart['price']; ?></div>
                              <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>" maxlength="2">
                              <button type="submit" class="fas fa-edit" name="update_qty"></button>
                           </div>
                           <div class="sub-total"> sub total : <span>RM<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></span> </div>
                     </form>
               <?php
                     $grand_total += $sub_total;
                  }
               } else {
                  echo '<p class="empty">your cart is empty</p>';
               }
               ?>

         </div>

         <div class="cart-total">
               <p>cart total : <span>RM<?= $grand_total; ?></span></p>
               <a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">Proceed To Checkout</a>
         </div>

         <div class="more-btn">
               <form action="" method="post">
                  <button type="submit" class="delete-btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" name="delete_all" onclick="return confirm('delete all from cart?');">delete all</button>
               </form>
               <a href="menu.php" class="btn">Continue Shopping</a>
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
