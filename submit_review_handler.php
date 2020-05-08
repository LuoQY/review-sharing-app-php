<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>

<html>
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
  </style>
</head>
<body>
<?php

class Review {
	public $movie_name;
	public $content;
	public $rate;
	public $username;
	

 	function set_moviename($name) {
 		$this->movie_name = $name;
 	}

 	function set_content($con) {
 		$this->content = $con;
 	}

 	function set_rate($ra) {
 		$this->rate = $ra;
 	}

 	function set_username($user) {
 		$this->username = $user;
 	}
 }

 $review = new Review();
 	
 $review->set_moviename($_POST['movie']);
 $review->set_content($_POST['review']);
 $review->set_rate($_POST['rate']);
 $review->set_username($_SESSION['username']);

 $review->set_moviename(str_replace('\'', '\'\'', $review->movie_name));
 $review->set_content(str_replace('\'', '\'\'', $review->content));

 $conn = mysqli_connect('localhost','root','', 'rottenpotatoes');
 if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
 }
 $sql = "INSERT INTO reviews (movie, content, rate, username) VALUES ('" . $review->movie_name . "', '" . $review->content . "'," . $review->rate . ",'" . $review->username . "')";

if ($conn->query($sql) === TRUE) {
    $message = "<h1>You published a new review for " . $review->movie_name . "!</h1>";
} else {
    $message =  "<h1>Error: " . "<br>" . $conn->error . "</h1>";
}

 mysqli_close($conn);
    
?>


<?php include("navigation.php"); ?>
  
<div class="container-fluid text-center">    
  <div class="row content">

    <!--left bar-->
    <div class="col-sm-2 sidenav">

    </div>

    <!--center-->
    <div class="col-sm-8 text-left"> 
      <?php echo $message?>
      <hr>
      <p></p>
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
</body>
</html>