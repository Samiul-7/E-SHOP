<?php

include 'components/connect.php';

session_start();
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'components/user_header.php'; ?>
<section class="hero">
   <div class="swiper hero-slider">
      <div class="swiper-wrapper">
         <div class="swiper-slide slide">
            <div class="content">
               <span>order online</span>
               <h3>Your favourite Cloths</h3>
            </div>
            <div class="image">
               <img src="images/image3.jpeg" alt="">
            </div>
         </div>
      </div>
      <div class="swiper-pagination"></div>
   </div>
</section>
<section class="category">
   <h1 class="title">Cloths category</h1>
   <div class="box-container">
      <a href="category.php?category=Mens" class="box">
         <h3>Man</h3>
      </a>
      <a href="category.php?category=Womens" class="box">
         <h3>Woman</h3>
      </a>
      <a href="category.php?category=Kids" class="box">
         <h3>Kids</h3>
      </a>
   </div>
</section>
<section>
   <p>Choose your category <br> Grab your favs <br> Check for the best deal<br> happy Shopping!<br></p>
   <p>Please Message us! <br> We are eager to listen to you</p>
</section>
<?php include 'components/footer.php'; ?>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<!-- custom js file link  -->
<script src="js/script.js"></script>
<script>
var swiper = new Swiper(".hero-slider", {
   loop:true,
   grabCursor: true,
   effect: "flip",
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
});

</script>

</body>
</html>