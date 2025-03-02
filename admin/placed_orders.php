<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update_payment'])){
   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_status->execute([$payment_status, $order_id]);
   $message[] = 'Payment status updated!';
}
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Placed Orders</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   
   <style>
      body {
         font-family: Arial, sans-serif;
         background-color: #eef2f3;
         margin: 0;
         padding: 20px;
         display: flex;
         flex-direction: column;
         align-items: center;
      }
      .placed-orders {
         width: 100%;
         max-width: 1100px;
         background: #ffffff;
         padding: 25px;
         border-radius: 8px;
         box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      }
      .heading {
         text-align: center;
         font-size: 26px;
         margin-bottom: 20px;
         color: #333;
      }
      .box-container {
         display: flex;
         flex-wrap: wrap;
         gap: 15px;
         justify-content: center;
      }
      .box {
         background: #f8f9fa;
         padding: 15px;
         border-radius: 8px;
         width: 320px;
         border: 1px solid #ddd;
         box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      }
      .box p {
         margin: 8px 0;
         font-size: 15px;
         color: #555;
      }
      .box span {
         font-weight: bold;
         color: #222;
      }
      .drop-down {
         width: 100%;
         padding: 8px;
         margin-top: 10px;
         border-radius: 4px;
         border: 1px solid #ccc;
      }
      .flex-btn {
         display: flex;
         justify-content: space-between;
         margin-top: 10px;
      }
      .btn, .delete-btn {
         padding: 10px 15px;
         border: none;
         cursor: pointer;
         text-align: center;
         border-radius: 5px;
         font-size: 14px;
      }
      .btn {
         background: #007bff;
         color: white;
      }
      .delete-btn {
         background: #ff4d4d;
         color: white;
      }
   </style>
</head>
<body>
<?php include '../components/admin_header.php' ?>
<!-- Placed Orders Section -->
<section class="placed-orders">
   <h1 class="heading">Placed Orders</h1>
   <div class="box-container">
   <?php
      $select_orders = $conn->prepare("
         SELECT orders.*, users.name, users.email, users.number, users.address
         FROM `orders`
         INNER JOIN `users` ON orders.user_id = users.id
      ");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>User ID: <span><?= $fetch_orders['user_id']; ?></span></p>
      <p>Placed On: <span><?= $fetch_orders['placed_on']; ?></span></p>
      <p>Name: <span><?= $fetch_orders['name']; ?></span></p>
      <p>Email: <span><?= $fetch_orders['email']; ?></span></p>
      <p>Number: <span><?= $fetch_orders['number']; ?></span></p>
      <p>Address: <span><?= $fetch_orders['address']; ?></span></p>
      <p>Total Products: <span><?= $fetch_orders['total_products']; ?></span></p>
      <p>Total Price: <span>$<?= $fetch_orders['total_price']; ?>/-</span></p>
      <p>Payment Method: <span><?= $fetch_orders['method']; ?></span></p>
      <form action="" method="POST">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
         <select name="payment_status" class="drop-down">
            <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
         </select>
         <div class="flex-btn">
            <input type="submit" value="Update" class="btn" name="update_payment">
            <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Delete this order?');">Delete</a>
         </div>
      </form>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">No orders placed yet!</p>';
   }
   ?>
   </div>
</section>
<!-- Placed Orders Section Ends -->

</body>
</html>
