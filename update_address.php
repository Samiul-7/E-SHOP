<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};
if(isset($_POST['submit'])){
   // Build the address using only flat, town, and city
   $address = $_POST['flat'] .', '.$_POST['town'].', '.$_POST['city'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   // Update the user's address in the database
   $update_address = $conn->prepare("UPDATE `users` set address = ? WHERE id = ?");
   $update_address->execute([$address, $user_id]);
   $message[] = 'address saved!';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Address</title>
   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'components/user_header.php'; ?>
<section class="form-container">
   <form action="" method="post">
      <h3>Your Address</h3>
      <!-- Address form fields -->
      <input type="text" class="box" placeholder="Flat No." required maxlength="50" name="flat">
      <input type="text" class="box" placeholder="Town Name" required maxlength="50" name="town">
      <input type="text" class="box" placeholder="City Name" required maxlength="50" name="city">
      <input type="submit" value="Save Address" name="submit" class="btn">
   </form>
</section>
<?php include 'components/footer.php'; ?>
<!-- Custom JS File Link -->
<script src="js/script.js"></script>
</body>
</html>
