<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Rotten Potatoes</title>
</head>
<body>

<?php

  class ReviewShow {
    public $content;
    public $rate;
    public $username;
    public $date;
    public $movie;
    public $like;
    public $id;

    function set_content($con) {
      $this->content = $con;
    }

    function set_rate($ra) {
      $this->rate = $ra;
    }

    function set_username($user) {
      $this->username = $user;
    }

    function set_date($d) {
      $this->date = $d;
    }

    function set_movie($m) {
      $this->movie = $m;
    }

    function set_like($l) {
      $this->like = $l;
    }

    function set_id($i) {
      $this->id = $i;
    }
  }


  $conn = mysqli_connect('localhost','root','', 'rottenpotatoes');
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM users WHERE username='" . $_SESSION['username'] . "'";
  $response = $conn->query($sql);

  if (!$response) {
    die('<p>Error retrieving reviews from database!<br />'.
        'Error: ' . mysqli_connect_error() . '</p>');
  }

  while($row = $response->fetch_assoc()) {
    $username = $row['username'];
    $email = $row['email'];
    $create_time = $row['create_time'];
  }

  $sql_like = "SELECT t.* FROM reviews t, user_likes WHERE t.id=user_likes.review_id AND user_likes.username='" . $_SESSION['username'] . "'";
  $response = $conn->query($sql_like);

  $reviews_arr = [];

  while($row = $response->fetch_assoc()) {
    $review = new ReviewShow();
    $review->set_content($row['content']);
    $review->set_rate($row['rate']);
    $review->set_username($row['username']);
    $review->set_date($row['datetime']);
    $review->set_movie($row['movie']);
    $review->set_like($row['likes']);
    $review->set_id($row['id']);
    array_push($reviews_arr, $review);
  }

  mysqli_close($conn);


?>


<?php 

  include("navigation.php"); 

?>
  
<div class="container-fluid text-center">    
  <div class="row content">

    <!--left bar-->
    <div class="col-sm-2 sidenav">

    </div>

    <!--center-->
    <div class="col-sm-8 text-left"> 
      <div class="row">
        <div class="col-sm-3">
          <img src="user.png" class="img-thumbnail" alt="Cinque Terre">
        </div>
        <div class="col-sm-9">
          <h4 class="text-muted">Personal Information</h4>
          <hr>
          <h4>Username: <?php echo $_SESSION['username'] ?></h4>
          <h4><br>Email: <?php echo $email ?></h4>
          <h4><br>Became a member since: <?php echo $create_time ?></h4>
        </div>
      </div>
      <hr>
      <h4 class="text-muted">The reviews you liked:</h4>
      <br>
      <?php 
       foreach ($reviews_arr as $r) { ?>
        <div class="panel panel-warning">
            <div class="panel-heading"> 
              <?php echo $r->username ?> | Rating: <?php echo $r->rate ?>/10 | <?php echo $r->movie ?>
              <span style="float:right;"><?php echo $r->date ?></span>
            </div>
            <div class="panel-body"><?php echo $r->content ?></div>
          </div>
        
       <?php 
          }

       ?>

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
