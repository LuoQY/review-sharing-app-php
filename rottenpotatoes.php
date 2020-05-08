<!DOCTYPE html>
<html lang="en">
<head>
  <title>Rotten Potatoes</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #907163;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }

    * {box-sizing:border-box}

    /* Slideshow container */
    .slideshow-container {
      max-width: 800px;
      position: relative;
      margin: auto;
      height: 450px;
    }

    /* Hide the images by default */
    .mySlides {
      display: inline-block;
    }

    /* Next & previous buttons */
    .prev, .next {
      cursor: pointer;
      position: absolute;
      top: 50%;
      width: auto;
      margin-top: -22px;
      padding: 16px;
      color: white;
      font-weight: bold;
      font-size: 18px;
      transition: 0.6s ease;
      border-radius: 0 3px 3px 0;
      user-select: none;
    }

    /* Position the "next button" to the right */
    .next {
      right: 0;
      border-radius: 3px 0 0 3px;
    }

    /* On hover, add a black background color with a little bit see-through */
    .prev:hover, .next:hover {
      background-color: rgba(0,0,0,0.8);
    }

    /* Caption text */
    .text {
      color: #f2f2f2;
      font-size: 15px;
      padding: 8px 12px;
      position: absolute;
      bottom: 8px;
      width: 100%;
      text-align: center;
    }

    /* Number text (1/3 etc) */
    .numbertext {
      color: #f2f2f2;
      font-size: 12px;
      padding: 8px 12px;
      position: absolute;
      top: 0;
    }

    /* The dots/bullets/indicators */
    .dot {
      cursor: pointer;
      height: 15px;
      width: 15px;
      margin: 0 2px;
      background-color: #bbb;
      border-radius: 50%;
      display: inline-block;
      transition: background-color 0.6s ease;
    }

    .active, .dot:hover {
      background-color: #717171;
    }

    /* Fading animation */
    .fade {
      -webkit-animation-name: fade;
      -webkit-animation-duration: 1.5s;
      animation-name: fade;
      animation-duration: 1.5s;
    }

    @-webkit-keyframes fade {
      from {opacity: .4}
      to {opacity: 1}
    }

    @keyframes fade {
      from {opacity: .4}
      to {opacity: 1}
    }
  </style>
</head>
<body>

<?php include("navigation.php"); ?>
  
<div class="container-fluid text-center">    
  <div class="row content">

    <!--left bar-->
    <div class="col-sm-2 sidenav">

    </div>

    <!--center-->
    <div class="col-sm-8 text-left"> 
      <!-- Slideshow container -->
      <div class="slideshow-container">

        <!-- Full-width images with number and caption text -->
        <div class="mySlides">
          <div class="numbertext">1 / 3</div>
          <img src="avengers.jpg" style="width:100%">
          <div class="text"></div>
        </div>

        <div class="mySlides">
          <div class="numbertext">2 / 3</div>
          <img src="avengers2.jpg" style="width:100%">
          <div class="text"></div>
        </div>

        <div class="mySlides">
          <div class="numbertext">3 / 3</div>
          <img src="spiderman.jpg" style="width:100%">
          <div class="text"></div>
        </div>

        <!-- Next and previous buttons -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
      </div>
      <br>

      <!-- The dots/circles -->
      <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
      </div>
      
      <hr>
      <div class="container-fluid bg-3 text-center">    
        <h3>Latest Reviews</h3><br>
          <?php
            $conn = mysqli_connect('localhost','root','', 'rottenpotatoes');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM reviews ORDER BY datetime DESC limit 6";

            $response = $conn->query($sql);

            if ($response){
              $i = 0;
              while($row = $response->fetch_assoc()) { 
                if($i%3 == 0) { ?>
                  <div class="row">

                <?php } ?>
                <div class="col-sm-4">
                  <div class="panel panel-danger">
                    <div class="panel-heading"><?php echo $row['movie']; ?></div>
                    <div class="panel-body"><?php echo $row['content']; ?></div>
                  </div>
                </div>

                <?php if($i%3 == 2) { ?>
                  </div><br>

                <?php }
                $i++;
              }
            }

          ?>
      </div><br>


    </div>

    <!--right bar-->
    <div class="col-sm-2 sidenav">
      <div class="well">
      </div>
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
  <p>@RottenPotatoes Co.</p>
</footer>

<script>
var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}

</script>

</body>
</html>
