
<header class="header">
   <section class="flex">
      <a href="dashboard.php" class="logo">AdminPanel</a>
      <nav class="navbar">
         <a href="dashboard.php" class="nav-link">Home</a>
         <a href="products.php" class="nav-link">Products</a>
         <a href="placed_orders.php" class="nav-link">Orders</a>
         <a href="admin_accounts.php" class="nav-link">Admins</a>
         <a href="users_accounts.php" class="nav-link">Users</a>
         <a href="messages.php" class="nav-link">Messages</a>
         <div class="profile">
         <?php
         $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
         $select_profile->execute([$admin_id]);
         $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile['name']; ?></p>
         </div>
         <a href="update_profile.php" class="nav-link">Update Profile</a>
         <a href="register_admin.php" class="nav-link">register</a>
         <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');" class="nav-link">
            Logout
         </a>
      </nav>
   </section>
</header>

<style>
   body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
   }

   .header {
      background-color: #333;
      color: white;
      padding: 10px 20px;
      position: fixed;
      width: 100%;
      z-index: 1000;
   }

   .flex {
      display: flex;
      justify-content: space-between;
      align-items: center;
   }

   .logo {
      font-size: 20px;
      font-weight: bold;
      color: white;
      text-decoration: none;
   }

   .logo span {
      color: #ff5722;
   }

   .navbar {
      display: flex;
      gap: 10px;
   }

   .nav-link {
      color: white;
      text-decoration: none;
      padding: 5px 10px;
      font-size: 14px;
      border-radius: 3px;
      transition: background-color 0.3s;
   }

   .nav-link:hover {
      background-color: #555;
   }

   .icons {
      display: flex;
      gap: 10px;
      cursor: pointer;
   }

   .profile {
      display: none;
      position: absolute;
      top: 60px;
      right: 20px;
      background-color: white;
      color: #333;
      padding: 15px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border-radius: 5px;
   }

   .profile p {
      margin: 0;
      font-size: 16px;
   }

   .profile .btn {
      display: inline-block;
      margin-top: 10px;
      padding: 5px 10px;
      background-color: #ff5722;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s;
   }

   .profile .btn:hover {
      background-color: #e64a19;
   }

   .delete-btn {
      background-color: #ff5722;
      color: white;
      border: none;
      padding: 5px 10px;
      font-size: 14px;
      cursor: pointer;
      border-radius: 5px;
      transition: background-color 0.3s;
   }

   .delete-btn:hover {
      background-color: #e64a19;
   }

   @media screen and (max-width: 768px) {
      .navbar {
         flex-direction: column;
         display: none;
         position: absolute;
         top: 60px;
         right: 0;
         background-color: #333;
         width: 100%;
         text-align: right;
      }

      .navbar a {
         padding: 8px;
         font-size: 14px;
      }

      #menu-btn {
         display: block;
      }

      .icons {
         gap: 8px;
      }

      .navbar.active {
         display: flex;
      }
   }
</style>

<script>
   document.getElementById('menu-btn').addEventListener('click', () => {
      document.querySelector('.navbar').classList.toggle('active');
   });

   document.getElementById('user-btn').addEventListener('click', () => {
      document.querySelector('.profile').classList.toggle('active');
   });
</script>
