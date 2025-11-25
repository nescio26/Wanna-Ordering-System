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
   <title>home</title>
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

<section class="home-hero">
   <div class="swiper hero-slider">
      <div class="swiper-wrapper">
         <div class="swiper-slide carousel">
            <div class="details">
               <h3>Nasi Lemak</h3>
               <a href="menu.php" class="btn">See Menus</a>
            </div>
            <div class="picture">
               <img src="images/Display-1.png" alt="Nasi Lemak">
            </div>
         </div>
         <div class="swiper-slide carousel">
            <div class="details">
               <h3>Chicken Chop </h3>
               <a href="menu.php" class="btn">See Menus</a>
            </div>
            <div class="picture">
               <img src="images/Display-2.png" alt="Chicken Chop">
            </div>
         </div>
         <div class="swiper-slide carousel">
            <div class="details">
               <h3>Spaghetti Bolognese</h3>
               <a href="menu.php" class="btn">See Menus</a>
            </div>
            <div class="picture">
               <img src="images/Display-3.png" alt="Spaghetti Bolognese">
            </div>
         </div>
      </div>
      <div class="swiper-pagination"></div>
   </div>
</section>

<section class="category">

   <h1 class="title">Food Category</h1>

   <div class="box-container">

      <a href="category.php?category=malaysian" class="box">
         <img src="images/logo-1.png" alt="">
         <h3>Malaysian</h3>
      </a>

      <a href="category.php?category=western" class="box">
         <img src="images/logo-2.png" alt="">
         <h3>Western</h3>
      </a>

      <a href="category.php?category=drinks" class="box">
         <img src="images/logo-3.png" alt="">
         <h3>Drinks</h3>
      </a>

      <a href="category.php?category=desserts" class="box">
         <img src="images/logo-4.png" alt="">
         <h3>Desserts</h3>
      </a>

   </div>

</section>

<section class="products">

   <h1 class="title">Top Selling</h1>

   <div class="box-container">

      <?php
         $select_products_query = "SELECT * FROM `products` LIMIT 6";
         $select_products_result = mysqli_query($conn, $select_products_query);
         if (mysqli_num_rows($select_products_result) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products_result)) {
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="product_id" value="<?= $fetch_products['product_id']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
         <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
         <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
         <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
         <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="<?= $fetch_products['name']; ?>">
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

   <div class="more-btn">
      <a href="menu.php" class="btn">view all</a>
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

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".hero-slider", {
   loop:true,
   grabCursor: true,
   effect: "flip",
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
});

</script>

</body>
</html>
