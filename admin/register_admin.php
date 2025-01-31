<?php

include '../components/connect.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
};
if(isset($_POST['submit'])){
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
   $select_admin->execute([$name]);
   
   if($select_admin->rowCount() > 0){
      $message[] = 'username already exists!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm passowrd not matched!';
      }else{
         $insert_admin = $conn->prepare("INSERT INTO `admin`(name, password) VALUES(?,?)");
         $insert_admin->execute([$name, $cpass]);
         $message[] = 'new admin registered!';
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
   <title>Register</title>
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
         background-color: #007bff;
         color: #fff;
         font-size: 16px;
         cursor: pointer;
         transition: background-color 0.3s;
      }
      .btn:hover {
         background-color: #0056b3;
      }
   </style>
</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- Register admin section starts -->
<section class="form-container">
   <form action="" method="POST">
      <h3>Register New</h3>
      <input type="text" name="name" maxlength="20" required placeholder="Enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="Enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" maxlength="20" required placeholder="Confirm your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Register Now" name="submit" class="btn">
   </form>
</section>
<!-- Register admin section ends -->

<!-- Custom JS file link -->
<script src="../js/admin_script.js"></script>

</body>
</html>
