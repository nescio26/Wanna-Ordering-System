<?php
include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}



if (isset($_POST['send'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $msg = $_POST['msg'];

    $select_message_query = "SELECT message FROM `users` WHERE user_id = '$user_id'";
    $select_message_result = mysqli_query($conn, $select_message_query);
    $existing_message = mysqli_fetch_assoc($select_message_result);

    if (!empty($existing_message['message'])) {
        $message[] = 'You have already sent a message!';
    } else {
        $update_message_query = "UPDATE `users` SET message = '$msg' WHERE user_id = '$user_id'";
        mysqli_query($conn, $update_message_query);
        
        $message[] = 'Message sent successfully!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>

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
                    <a href="profile.php" class="btn">Profile</a>
                    <a href="components/user_logout.php" onclick="return confirm('Logout from this website?');" class="delete-btn">Logout</a>
                </div>
            <?php
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
    <h3>Contact Us</h3>
    <p><a href="home.php">Home</a> <span> / Contact</span></p>
</div>

<section class="contact">
    <div class="row">
        <div class="image">
            <img src="images/contact-us.png" alt="Contact-Us">
        </div>
        <form action="" method="post">
            <h3>Tell Us Something!</h3>
            <input type="text" name="name" maxlength="50" class="box" placeholder="Enter your name" required>
            <input type="number" name="number" min="0" max="9999999999" class="box" placeholder="Enter your number" required maxlength="12">
            <input type="email" name="email" maxlength="50" class="box" placeholder="Enter your email" required>
            <textarea name="msg" class="box" required placeholder="Enter your message" maxlength="500" cols="30" rows="10"></textarea>
            <input type="submit" value="Send Message" name="send" class="btn">
        </form>
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
