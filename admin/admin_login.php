<?php
include '../components/connect.php';

session_start();

if (isset($_POST['submit'])) {
    // Sanitize the admin ID and password inputs
    $admin_id = mysqli_real_escape_string($conn, $_POST['admin_id']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);

    $select_admin_query = "SELECT * FROM `admin` WHERE admin_id = '$admin_id' AND password = '$pass'";
    $result = mysqli_query($conn, $select_admin_query);

    if (mysqli_num_rows($result) > 0) {
        $fetch_admin = mysqli_fetch_assoc($result);
    
        $_SESSION['admin_id'] = $fetch_admin['admin_id'];
    
        header('location: dashboard.php');
        exit();
    } else {
        echo "<script>alert('Incorrect admin ID or password!'); window.location.href='admin_login.php';</script>";
        exit();
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Login</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

<section class="form-container">
   <form action="" method="POST">
      <h3>Login Now</h3>    
      <input type="text" name="admin_id" maxlength="20" required placeholder="Enter your Admin ID" class="box">
      <input type="password" name="pass" maxlength="20" required placeholder="Enter your password" class="box">
      <input type="submit" value="Login Now" name="submit" class="btn">
   </form>
</section>

</body>
</html>
