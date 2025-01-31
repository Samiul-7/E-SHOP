<?php

include '../components/connect.php';
session_start();
if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);
   
   if($select_admin->rowCount() > 0){
      $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
      $_SESSION['admin_id'] = $fetch_admin_id['id'];
      header('location:dashboard.php');
   }else{
      $message[] = 'incorrect username or password!';
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <style>
      body {
         font-family: Arial, sans-serif;
         background-color: grey;
         margin: 0;
         padding: 0;
         display: flex;
         justify-content: center;
         align-items: center;
         height: 100vh;
      }

      .form-container {
         background:white;
         padding: 30px;
         border-radius: 8px;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
         width: 100%;
         max-width: 400px;
         text-align: center;
      }

      .form-container h3 {
         font-size: 24px;
         margin-bottom: 20px;
         color: #333;
      }

      .form-container p {
         font-size: 14px;
         color: #555;
         margin-bottom: 20px;
      }

      .form-container p span {
         font-weight: bold;
         color: tomato;
      }

      .form-container .box {
         width: 100%;
         padding: 10px;
         margin-bottom: 15px;
         border: 1px solid #ddd;
         border-radius: 5px;
         outline: none;
         font-size: 14px;
      }

      .form-container .box:focus {
         border-color: tomato;
      }

      .form-container .btn {
         display: inline-block;
         width: 100%;
         padding: 10px;
         background:tomato;
         color: #fff;
         font-size: 16px;
         border: none;
         border-radius: 5px;
         cursor: pointer;
         transition: background 0.3s;
      }

      .form-container .btn:hover {
         background: tomato;
      }

      .form-container .message {
         margin-top: 20px;
         font-size: 14px;
         color: #f00;
      }
   </style>
</head>
<body>
<!-- Admin Login Form Section Starts -->
<section class="form-container">
   <form action="" method="POST">
      <h3>Login Now</h3>
      <p>Default Username = <span>admin1</span> & Password = <span>123</span></p>
      <input type="text" name="name" maxlength="20" required placeholder="Enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="Enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Login Now" name="submit" class="btn">
   </form>
</section>
<!-- Admin Login Form Section Ends -->
</body>
</html>
