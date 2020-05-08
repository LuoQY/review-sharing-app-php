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
      <h1>Become a Critic</h1>
      <p>Share your review to help others to know the movie </p>
      <hr>
      
      <?php if(isset($_SESSION['username'])) { ?>

        <form action="submit_review_handler.php" method="post">
          <div class="form-group">
            <label>Which movie you want to talk about?</label>
            <input type="text" class="form-control" name="movie">
          </div>
          <div class="form-group">
            <label>Review</label>
            <textarea class="form-control" rows="4" name="review"></textarea>
          </div>
          <div class="form-group">
            <label>Rate </label>
            <label class="radio-inline"><input type="radio" value='0' name="rate">0</label>
            <label class="radio-inline"><input type="radio" value='1' name="rate">1</label>
            <label class="radio-inline"><input type="radio" value='2' name="rate">2</label>
            <label class="radio-inline"><input type="radio" value='3' name="rate">3</label>
            <label class="radio-inline"><input type="radio" value='4' name="rate">4</label>
            <label class="radio-inline"><input type="radio" value='5' name="rate">5</label>
            <label class="radio-inline"><input type="radio" value='6' name="rate">6</label>
            <label class="radio-inline"><input type="radio" value='7' name="rate">7</label>
            <label class="radio-inline"><input type="radio" value='8' name="rate">8</label>
            <label class="radio-inline"><input type="radio" value='9' name="rate">9</label>
            <label class="radio-inline"><input type="radio" value='10' name="rate">10</label>
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>

      <?php } else { ?>
         <a href="login.php" class="btn btn-danger" role="button">Please Log In/Sign Up</a>
         <hr>
        <form>
          <div class="form-group">
            <label>Which movie you want to talk about?</label>
            <input type="text" class="form-control" name="movie" disabled>
          </div>
          <div class="form-group">
            <label>Review</label>
            <textarea class="form-control" rows="4" name="review" disabled></textarea>
          </div>
          <div class="form-group">
            <label>Rate </label>
            <label class="radio-inline"><input type="radio" value='0' name="rate">0</label>
            <label class="radio-inline"><input type="radio" value='1' name="rate">1</label>
            <label class="radio-inline"><input type="radio" value='2' name="rate">2</label>
            <label class="radio-inline"><input type="radio" value='3' name="rate">3</label>
            <label class="radio-inline"><input type="radio" value='4' name="rate">4</label>
            <label class="radio-inline"><input type="radio" value='5' name="rate">5</label>
            <label class="radio-inline"><input type="radio" value='6' name="rate">6</label>
            <label class="radio-inline"><input type="radio" value='7' name="rate">7</label>
            <label class="radio-inline"><input type="radio" value='8' name="rate">8</label>
            <label class="radio-inline"><input type="radio" value='9' name="rate">9</label>
            <label class="radio-inline"><input type="radio" value='10' name="rate">10</label>
          </div>
        </form>

      <?php } ?> 
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
