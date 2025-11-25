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
    <title>Category</title>

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
            $cart_query = "SELECT * FROM `cart` WHERE user_id = ?";
            $stmt = $conn->prepare($cart_query);
            $stmt->bind_param("s", $user_id);
            $stmt->execute();
            $count_cart_items = $stmt->get_result();
            $total_cart_items = $count_cart_items->num_rows;
            ?>
            <a href="search.php"><i class="fas fa-search"></i></a>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
            <div id="user-btn" class="fas fa-user"></div>
            <div id="menu-btn" class="fas fa-bars"></div>
        </div>

        <div class="profile">
            <?php
            if ($user_id != '') {
                $profile_query = "SELECT * FROM `users` WHERE user_id = ?";
                $stmt = $conn->prepare($profile_query);
                $stmt->bind_param("s", $user_id);
                $stmt->execute();
                $select_profile = $stmt->get_result();

                if ($select_profile->num_rows > 0) {
                    $fetch_profile = $select_profile->fetch_assoc();
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

<section class="products">
    <h1 class="title">Food Category</h1>
    <div class="box-container">
        <?php
        if (isset($_GET['category'])) {
            $category = $_GET['category'];
            $products_query = "SELECT * FROM `products` WHERE category = ?";
            $stmt = $conn->prepare($products_query);
            $stmt->bind_param("s", $category);
            $stmt->execute();
            $select_products = $stmt->get_result();

            if ($select_products->num_rows > 0) {
                while ($fetch_products = $select_products->fetch_assoc()) {
        ?>
        <form action="" method="post" class="box">
            <input type="hidden" name="product_id" value="<?= $fetch_products['product_id']; ?>">
            <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
            <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
            <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
            <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
            <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
            <div class="name"><?= $fetch_products['name']; ?></div>
            <div class="flex">
                <div class="price"><span>RM</span><?= $fetch_products['price']; ?></div>
                <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
            </div>
        </form>
        <?php
                }
            } else {
                echo '<p class="empty">No products available in this category!</p>';
            }
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
    </div>
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
