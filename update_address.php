<?php
include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:home.php');
    exit();
}

if (isset($_POST['submit'])) {
    $address = $_POST['House_No'] . ', ' . $_POST['Road_Name'] . ', ' . $_POST['Town'] . ', ' . $_POST['City'] . ', ' . $_POST['State'] . ', ' . $_POST['Country'] . ' - ' . $_POST['Zip_code'];

    // Using mysqli to update the address
    $update_address_query = "UPDATE `users` SET address = '$address' WHERE user_id = '$user_id'";
    if (mysqli_query($conn, $update_address_query)) {
        $message[] = 'Address updated successfully!';
    } else {
        $message[] = 'Failed to update address!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Address</title>
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
    </section>
</header>

<section class="form-container">
    <form action="" method="post">
        <h3>Update Your Address</h3>
        

        <input type="text" class="box" placeholder="House No." required maxlength="50" name="House_No">
        <input type="text" class="box" placeholder="Road Name" required maxlength="50" name="Road_Name">
        <input type="text" class="box" placeholder="Town" required maxlength="50" name="Town">
        <input type="text" class="box" placeholder="City" required maxlength="50" name="City">
        <input type="text" class="box" placeholder="State" required maxlength="50" name="State">
        <input type="text" class="box" placeholder="Country" required maxlength="50" name="Country">
        <input type="number" class="box" placeholder="Zip Code" required max="999999" min="0" maxlength="6" name="Zip_code">
        <input type="submit" value="Save Address" name="submit" class="btn">
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
