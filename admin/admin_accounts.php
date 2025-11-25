   <?php
   include '../components/connect.php';

   session_start();

   // Ensure admin is logged in
if (!isset($_SESSION['admin_id'])) {
   header('location:admin_login.php');
   exit();
}

$admin_id = $_SESSION['admin_id'];

   ?>

   <!DOCTYPE html>
   <html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Admins Accounts</title>
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
               $select_profile_result = mysqli_query($conn, $select_profile_query);
               $fetch_profile = mysqli_fetch_assoc($select_profile_result);
            ?>
            <p><?= $fetch_profile['name']; ?></p>
            <a href="update_profile.php" class="btn">Update Profile</a>
            <a href="../components/admin_logout.php" onclick="return confirm('Logout from this website?');" class="delete-btn">Logout</a>
         </div>
      </section>
   </header>

   <section class="accounts">
      <h1 class="heading">Admins Account</h1>
      <div class="box-container">
         <div class="box">
            <p>Register New Admin</p>
            <a href="register_admin.php" class="option-btn">Register</a>
         </div>

         <?php
            $select_account_query = "SELECT * FROM `admin`";
            $select_account_result = mysqli_query($conn, $select_account_query);
            if(mysqli_num_rows($select_account_result) > 0){
               while($fetch_accounts = mysqli_fetch_assoc($select_account_result)){  
         ?>
         <div class="box">
            <p> Admin ID: <span><?= $fetch_accounts['admin_id']; ?></span> </p>
            <p> Username: <span><?= $fetch_accounts['name']; ?></span> </p>
            <div class="flex-btn">
               <a href="admin_accounts.php?delete=<?= $fetch_accounts['admin_id']; ?>" class="delete-btn" onclick="return confirm('Delete this account?');">Delete</a>
               <?php
                  if($fetch_accounts['admin_id'] == $admin_id){
                     echo '<a href="update_profile.php" class="option-btn">Update</a>';
                  }
               ?>
            </div>
         </div>
         <?php
            }
         } else {
            echo '<p class="empty">No accounts available</p>';
         }
         ?>
      </div>
   </section>

   <script src="../js/admin_script.js"></script>

   </body>
   </html>
