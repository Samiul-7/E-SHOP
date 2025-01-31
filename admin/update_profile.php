<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   if(!empty($name)){
      $select_name = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
      $select_name->execute([$name]);
      if($select_name->rowCount() > 0){
         $message[] = 'username already taken!';
      }else{
         $update_name = $conn->prepare("UPDATE `admin` SET name = ? WHERE id = ?");
         $update_name->execute([$name, $admin_id]);
      }
   }

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $select_old_pass = $conn->prepare("SELECT password FROM `admin` WHERE id = ?");
   $select_old_pass->execute([$admin_id]);
   $fetch_prev_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);
   $prev_pass = $fetch_prev_pass['password'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = sha1($_POST['confirm_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);
   if($old_pass != $empty_pass){
      if($old_pass != $prev_pass){
         $message[] = 'old password not matched!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'confirm password not matched!';
      }else{
         if($new_pass != $empty_pass){
            $update_pass = $conn->prepare("UPDATE `admin` SET password = ? WHERE id = ?");
            $update_pass->execute([$confirm_pass, $admin_id]);
            $message[] = 'password updated successfully!';
         }else{
            $message[] = 'please enter a new password!';
         }
      }
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile Update</title>
   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- Inline custom CSS -->
   <style>
      * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
         font-family: Arial, sans-serif;
      }
      body {
         background-color: #f4f4f4;
         color: #333;
         font-size: 16px;
         line-height: 1.6;
      }
      .form-container {
         display: flex;
         justify-content: center;
         align-items: center;
         min-height: 100vh;
         padding: 20px;
         background-color: #f4f4f4;
      }
      form {
         background-color: #fff;
         padding: 20px;
         border-radius: 10px;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
         width: 100%;
         max-width: 400px;
         text-align: center;
      }
      form h3 {
         margin-bottom: 15px;
         font-size: 24px;
         color: #444;
      }
      .box {
         width: 100%;
         padding: 10px;
         margin: 10px 0;
         border: 1px solid #ccc;
         border-radius: 5px;
         font-size: 14px;
      }
      .btn {
         display: inline-block;
         padding: 10px 15px;
         border: none;
         border-radius: 5px;
         background-color: #28a745;
         color: #fff;
         font-size: 16px;
         cursor: pointer;
         transition: background-color 0.3s;
      }
      .btn:hover {
         background-color: #218838;
      }
   </style>
</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- Admin profile update section starts -->
<section class="form-container">
   <form action="" method="POST">
      <h3>Update Profile</h3>
      <input type="text" name="name" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" placeholder="<?= $fetch_profile['name']; ?>">
      <input type="password" name="old_pass" maxlength="20" placeholder="Enter your old password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="new_pass" maxlength="20" placeholder="Enter your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" maxlength="20" placeholder="Confirm your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Update Now" name="submit" class="btn">
   </form>
</section>
<!-- Admin profile update section ends -->

<!-- Custom JS file link -->
<script src="../js/admin_script.js"></script>

</body>
</html>
