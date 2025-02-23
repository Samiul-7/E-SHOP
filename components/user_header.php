<?php
   $cart_count_query = $conn->prepare("
      SELECT COUNT(*) AS cart_count FROM `cart` WHERE user_id = (SELECT id FROM `users` WHERE id = ?)
   ");
   $cart_count_query->execute([$user_id]);
   $cart_count = $cart_count_query->fetch(PDO::FETCH_ASSOC)['cart_count'];
?>

<header class="header">

   <section class="flex">

      <a href="home.php" class="logo">E-shop</a>

      <nav class="navbar">
         <a href="home.php">home</a>
         <a href="menu.php">All products</a>
         <a href="orders.php">orders</a>
         <a href="contact.php">contact</a>
      </nav>

      <div class="icons">
         <a href="search.php"><i class="fas fa-search"></i></a>
         <div id="user-btn" class="fas fa-user"></div>

         <!-- Display the cart count beside the cart icon -->
         <a href="cart.php" style="position: relative;">
            <i class="fas fa-shopping-cart"></i>
            <?php if ($cart_count > 0): ?>
               <span class="cart-count"><?= $cart_count; ?></span>
            <?php endif; ?>
         </a>

         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p class="name"><?= $fetch_profile['name']; ?></p>
         <div class="flex">
            <a href="profile.php" class="btn">profile</a>
            <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
         </div>
         <p class="account">
            <a href="login.php">login</a> or
            <a href="register.php">register</a>
         </p> 
         <?php
            }else{
         ?>
            <p class="name">please login first!</p>
            <a href="login.php" class="btn">login</a>
         <?php
          }
         ?>
      </div>
   </section>

</header>

<style>
   .cart-count {
      background-color: red;
      color: white;
      font-size: 5px;
      padding: 2px 6px;
      border-radius: 50%;
      position: absolute;
      top: -5px;
      right: -10px;
   }
</style>
