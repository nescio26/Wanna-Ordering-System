<?php
include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:home.php');
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $method = $_POST['method'];
    $address = $_POST['address'];
    $total_products = $_POST['total_products'];
    $total_price = $_POST['total_price'];

    $check_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'");

    if (mysqli_num_rows($check_cart) > 0) {
        if ($address == '') {
            $message[] = 'please add your address!';
        } else {
            $insert_order = mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) 
                                                  VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$total_price')");
            
            $delete_cart = mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'");
            
            echo "<script>alert('Your Payment Successful!'); window.location.href = 'orders.php';</script>";
        }
    } else {
        $message[] = 'your cart is empty';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checkout</title>
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
    <h3>checkout</h3>
    <p><a href="home.php">Home</a> <span> / Checkout</span></p>
</div>

<section class="checkout">
    <h1 class="title">order summary</h1>

    <form action="" method="post">
        <div class="cart-items">
            <h3>cart items</h3>
            <?php
            $grand_total = 0;
            $cart_items[] = '';
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'");
            if (mysqli_num_rows($select_cart) > 0) {
                while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                    $cart_items[] = $fetch_cart['name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ') - ';
                    $total_products = implode($cart_items);
                    $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
            ?>
            <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price">RM<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?></span></p>
            <?php
                }
            } else {
                echo '<p class="empty">your cart is empty!</p>';
            }
            ?>
            <p class="grand-total"><span class="name">grand total :</span><span class="price">RM<?= $grand_total; ?></span></p>
            <a href="cart.php" class="btn">view cart</a>
        </div>

        <input type="hidden" name="total_products" value="<?= $total_products; ?>"> 
        <input type="hidden" name="total_price" value="<?= $grand_total; ?>"> 
        <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>"> 
        <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>"> 
        <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>"> 
        <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">

        <div class="user-info">
            <h3>your info</h3>
            <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
            <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
            <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
            <a href="update_profile.php" class="btn">update info</a>
            <h3>Delivery Address</h3>
            <p><i class="fas fa-map-marker-alt"></i><span><?php if ($fetch_profile['address'] == '') { echo 'please enter your address'; } else { echo $fetch_profile['address']; } ?></span></p>
            <a href="update_address.php" class="btn">Update Address</a>
            <select name="method" class="box" required>
                <option value="" disabled selected>Select Payment Method --</option>
                <option value="cash on delivery">Cash on Delivery</option>
                <option value="credit card">Credit Card</option>
                <option value="online transfer">Online Transfer</option>
            </select>
            <input type="submit" value="place order" class="btn <?php if ($fetch_profile['address'] == '') { echo 'disabled'; } ?>" style="width:100%; background:var(--red); color:var(--white);" name="submit">
        </div>

    </form>
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
