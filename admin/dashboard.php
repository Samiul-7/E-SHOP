<?php

include '../components/connect.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>
   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- Custom CSS File Link -->
   <link rel="stylesheet" href="../css/admin_style.css">
   <style>
      .dashboard {
         display: flex;
         justify-content: center;
         align-items: center;
         height: calc(100vh - 70px); 
         padding: 20px;
      }

      .box-container {
         display: flex;
         justify-content: center;
         align-items: center;
         flex-direction: column;
         text-align: center;
      }

      .box {
         background-color: grey;
         padding: 20px;
         border-radius: 8px;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      }

      .box h3 {
         margin-bottom: 10px;
      }

      .btn {
         display: inline-block;
         padding: 10px 20px;
         background-color: #ff5722;
         color: white;
         text-decoration: none;
         border-radius: 5px;
         transition: background-color 0.3s;
      }

      .btn:hover {
         background-color: #e64a19;
      }
   </style>
</head>
<body>
<?php include '../components/admin_header.php'; ?>

<!-- Admin Dashboard Section Starts -->
<section class="dashboard">
   <h1 class="heading">Welcome to AdminPanel!</h1>
</section>
<!-- Admin Dashboard Section Ends -->

<!-- Custom JS File Link -->
<script src="../js/admin_script.js"></script>
</body>
</html>
