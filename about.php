<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>

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
                if ($user_id != '') {
                    $select_profile = mysqli_query($conn, "SELECT * FROM `users` WHERE user_id = '$user_id'");
                    if (mysqli_num_rows($select_profile) > 0) {
                        $fetch_profile = mysqli_fetch_assoc($select_profile);
            ?>
                <p class="name"><?= $fetch_profile['name']; ?></p>
                <div class="flex">
                    <a href="profile.php" class="btn">Profile</a>
                    <a href="components/user_logout.php" onclick="return confirm('Logout from this website?');" class="delete-btn">Logout</a>
                </div>
            <?php
                    }
                } else {
            ?>
                <p class="name">Please login first!</p>
                <a href="login.php" class="btn">Login</a>
            <?php
                }
            ?>
        </div>
    </section>
</header>

<div class="heading">
    <h3>About Us</h3>
    <p><a href="home.php">Home</a> <span> / About</span></p>
</div>

<section class="about">
    <div class="row">
        <div class="image">
            <img src="images/chef.png" alt="">
        </div>
        <div class="content">
            <h3>Why Choose Us?</h3>
            <p>"At Wanna Bistro, we offer a diverse menu featuring the rich flavors of Malaysian cuisine, delicious Western dishes, tempting desserts, and refreshing drinks, all crafted to satisfy every craving and taste."</p>
            <a href="menu.php" class="btn">Our Menu</a>
        </div>
    </div>
</section>

<section class="steps">
    <h1 class="title">Simple Steps</h1>
    <div class="box-container">
        <div class="box">
            <img src="images/step-1.png" alt="">
            <h3>Choose Your Order</h3>
            <p>Select from our menu featuring Malaysian, Western, Desserts, and Drinks. Find the perfect meal for you!</p>
        </div>
        <div class="box">
            <img src="images/step-2.png" alt="">
            <h3>Fast Delivery</h3>
            <p>After you place your order and pay, we’ll ensure your food arrives quickly and fresh right to your door.</p>
        </div>
        <div class="box">
            <img src="images/step-3.png" alt="">
            <h3>Enjoy Your Food</h3>
            <p>Savor your delicious meal and experience the convenience and taste that we bring to you!</p>
        </div>
    </div>
</section>


<section class="reviews">
      <h1 class="title">Customer's Reviews</h1>

      <div class="swiper reviews-slider">
         <div class="swiper-wrapper">

            <div class="swiper-slide">
               <img src="images/bruno.png" alt="Bruno Mars">
               <p>"The food was delicious, and delivery was super fast! I will definitely order again."</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
               <h3>Bruno Mars</h3>
            </div>

            <div class="swiper-slide">
               <img src="images/adele.png" alt="Adele">
               <p>"I love the variety of options. From Malaysian dishes to desserts, everything is amazing!"</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
               <h3>Adele</h3>
            </div>

            <div class="swiper-slide">
               <img src="images/mnasir.png" alt="M. Nasir">
               <p>"Quick delivery and fantastic food! Every meal is packed with flavor and fresh ingredients."</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
               <h3>M. Nasir</h3>
            </div>

            <div class="swiper-slide">
               <img src="images/siti.png" alt="Tok Ti">
               <p>"I ordered for the first time, and it was an excellent experience. Highly recommend!"</p>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
               <h3>Tok Ti</h3>
            </div>

         </div>

         <div class="swiper-pagination"></div>
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
    var swiper = new Swiper(".reviews-slider", {
        loop: true,
        grabCursor: true,
        spaceBetween: 20,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            0: { slidesPerView: 1 },
            700: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
        },
    });
</script>

</body>
</html>
