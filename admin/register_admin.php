<?php

include '../components/connect.php';

session_start();

if (!isset($_SESSION['admin_id'])) {
   header('location:admin_login.php');
   exit();
}

$admin_id = $_SESSION['admin_id'];

if (isset($_POST['submit'])) {

   // Ensure variables are assigned values from the form
   $name = isset($_POST['name']) ? $_POST['name'] : '';
   $pass = isset($_POST['pass']) ? $_POST['pass'] : '';
   $cpass = isset($_POST['cpass']) ? $_POST['cpass'] : '';

   $select_admin_query = "SELECT * FROM `admin` WHERE name = '$name'";
   $result = mysqli_query($conn, $select_admin_query);

   if (mysqli_num_rows($result) > 0) {
      $_SESSION['message'] = 'Username already exists!';
   } else {
      if ($pass != $cpass) {
         $_SESSION['message'] = 'Confirm password does not match!';
      } else {
         $insert_admin_query = "INSERT INTO `admin`(name, password) VALUES('$name', '$pass')";
         mysqli_query($conn, $insert_admin_query);
         $_SESSION['message'] = 'New admin registered!';
      }
   }

   header("Location: " . $_SERVER['PHP_SELF']);
   exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

<header class="header">
   <section class="flex">
      <a href="dashboard.php" class="logo">Admin<span>Panel</span></a>
      <nav class="navbar">
         <a href="dashboard.php">Home</a>
         <a href="products.php">Products</a>
         <a href="placed_orders.php">Orders</a>
         <a href="admin_accounts.php">Admins</a>
         <a href="users_accounts.php">Users</a>
      </nav>
      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>
      <div class="profile">
         <?php
            $select_profile_query = "SELECT * FROM `admin` WHERE admin_id = '$admin_id'";
            $result = mysqli_query($conn, $select_profile_query);
            $fetch_profile = mysqli_fetch_assoc($result);
         ?>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="update_profile.php" class="btn">Update Profile</a>
         <a href="../components/admin_logout.php" onclick="return confirm('Logout from this website?');" class="delete-btn">Logout</a>
      </div>
   </section>
</header>

<section class="form-container">
   <form action="" method="POST">
      <h3>Register New Admin</h3>
      <input type="text" name="name" maxlength="20" required placeholder="Enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="Enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" maxlength="20" required placeholder="Confirm your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Register Now" name="submit" class="btn">
   </form>
</section>

<script>
   <?php if (isset($_SESSION['message'])): ?>
      alert("<?php echo $_SESSION['message']; ?>");
      <?php unset($_SESSION['message']); ?>
   <?php endif; ?>
</script>

<script src="../js/admin_script.js"></script>

</body>
</html>
