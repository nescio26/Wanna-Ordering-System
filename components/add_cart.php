<?php

if (isset($_POST['add_to_cart'])) {

    if ($user_id == '') {
        header('location:login.php');
        exit;
    } else {

        $pid = $_POST['product_id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $image = $_POST['image'];
        $qty = $_POST['qty'];

        $check_cart_query = "SELECT * FROM `cart` WHERE name = ? AND user_id = ?";
        $stmt = mysqli_prepare($conn, $check_cart_query);
        mysqli_stmt_bind_param($stmt, "si", $name, $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $message[] = 'already added to cart!';
        } else {
            $insert_cart_query = "INSERT INTO `cart`(user_id, product_id, name, price, quantity, image) VALUES(?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insert_cart_query);
            mysqli_stmt_bind_param($stmt, "iissis", $user_id, $pid, $name, $price, $qty, $image);
            mysqli_stmt_execute($stmt);
            $message[] = 'added to cart!';
        }

        mysqli_stmt_close($stmt);
    }
}

?>
