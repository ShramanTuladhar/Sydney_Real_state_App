<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

include 'components/save_send.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Find Your Dream House</title>
   <link rel="stylesheet" href="css/main.css">
</head>
<body>

<!-- Navbar -->
<div class="navbar">
   <div class="logo">
      <a href="home.php"><img src="icon/logo.png" alt="Logo" width="100"></a>
   </div>
   <div class="menu">
      <a href="home.php">Home</a>
      <a href="listings.php">Properties</a>
      <a href="evaluation.php">Evaluation</a>
      <a href="post_property.php">Post Property</a>
      <a href="about.php">About us</a>
      <a href="contact.php">Contact us</a>
      <?php if($user_id == '') { ?>
         <a href="login.php" class="signup-button" style="color: aliceblue;">Log in / Sign up</a>
      <?php } else { ?>
         <a href="update.php" class="signup-button" style="color: aliceblue;">Profile</a>
      <?php } ?>
   </div>
</div>

<!-- Poster Section -->
<div class="poster">
   <img src="icon/Find.png" alt="Poster Image">
</div>

   
    <div class="slideshow-container">

        <div class="mySlides fade">
            <img src="icon/team.png" alt="Our Team">
            <div class="text">Our Team</div>
        </div>
        
        <div class="mySlides fade">
            <img src="icon/house1.jpg" alt="Houses">
            <div class="text">Houses</div>
        </div>
    
        <div class="mySlides fade">
            <img src="icon/house2.jpg" alt="Houses">
            <div class="text">Houses</div>
        </div>
    
        <div class="mySlides fade">
            <img src="icon/house3.jpg" alt="Houses">
            <div class="text">Houses</div>
        </div>
    </div>
    
    
        <div style="text-align:center">
          <span class="dot" onclick="currentSlide(1)"></span> 
          <span class="dot" onclick="currentSlide(2)"></span> 
          <span class="dot" onclick="currentSlide(3)"></span> 
          <span class="dot" onclick="currentSlide(4)"></span> 
        </div>
        
    
    
        <!--This is the js to fade the image-->
        <script>
            let slideIndex = 0;
            showSlides();
          
            function showSlides() {
              let i;
              let slides = document.getElementsByClassName("mySlides");
              let dots = document.getElementsByClassName("dot");
              
              for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none"; // Hide all slides
              }
              
              slideIndex++;
              if (slideIndex > slides.length) { slideIndex = 1; }
              
              for (i = 0; i < dots.length; i++) {
                dots[i].classList.remove("active");
              }
              
              slides[slideIndex - 1].style.display = "block"; // Show current slide
              dots[slideIndex - 1].classList.add("active");
              
              setTimeout(showSlides, 2000); // Change slide every 3 seconds
            }
          
            function currentSlide(n) {
              slideIndex = n - 1; // Adjust for zero-based index
              showSlides();
            }
          </script>
    </div>

              <!-- Categories Section -->
<div class="categories">
    <h2>Categories</h2>
    <div class="category-icons">
        <a href="listings.php?category=house" class="category">
            <img src="icon/homes-icon.png" alt="Homes">
            <p>Homes</p>
        </a>
        <a href="listings.php?category=flat" class="category">
            <img src="icon/building-icon.png" alt="Buildings">
            <p>Buildings</p>
        </a>
        <a href="listings.php?category=land" class="category">
            <img src="icon/land-icon.png" alt="Lands">
            <p>Lands</p>
        </a>
        <a href="listings.php?category=shop" class="category">
            <img src="icon/store-icon.png" alt="Stores">
            <p>Stores</p>
        </a>
    </div>
</div>




    <footer class="footer">
        <div class="footer-social">
          <a href="#"><i class="fab fa-facebook-f"><img src="icon/icons8-facebook-30.png"></i></a>
          <a href="#"><i class="fab fa-twitter"><img src="icon/icons8-twitter-30.png"></i></a>
          <a href="#"><i class="fab fa-pinterest"></i><img src="icon/icons8-pinterest-30.png"></a>
          <a href="#"><i class="fab fa-linkedin-in"><img src="icon/icons8-linkedin-30.png"></i></a>
          <a href="#"><i class="fab fa-youtube"><img src="icon/icons8-youtube-30.png"></img></a>
        </div>
        <div class="footer-links">
          <a href="#">Advertise with us</a>
          <a href="#">Contact us</a>
          <a href="#">Agent admin</a>
          <a href="#">Media sales</a>
          <a href="#">Legal</a>
          <a href="#">Privacy settings</a>
          <a href="#">Privacy centre</a>
          <a href="#">Site map</a>
          <a href="#">Careers</a>
        </div>
      </footer>
      

</body>
</html>


    <!-- JS to toggle form -->
    <script>
        var LoginForm = document.getElementById("LoginForm");
        var RegForm = document.getElementById("RegForm");
        var Indicator = document.getElementById("Indicator");

        function register() {
            RegForm.style.transform = "translateX(0px)";
            LoginForm.style.transform = "translateX(0px)";
            Indicator.style.transform = "translateX(100px)";
        }

        function login() {
            RegForm.style.transform = "translateX(300px)";
            LoginForm.style.transform = "translateX(300px)";
            Indicator.style.transform = "translateX(0px)";
        };

       
    </script>


<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

<script>

   let range = document.querySelector("#range");
   range.oninput = () =>{
      document.querySelector('#output').innerHTML = range.value;
   }

</script>

</body>
</html>