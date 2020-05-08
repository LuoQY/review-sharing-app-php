<!DOCTYPE html>
<html lang="en">
<head>
  <title>Rotten Potatoes</title>
</head>
<body>

<?php 
  $_SESSION['username'] = null;
  include("navigation.php"); 
?>
  
<div class="container-fluid text-center">    
  <div class="row content">

    <!--left bar-->
    <div class="col-sm-2 sidenav">

    </div>

    <!--center-->
    <div class="col-sm-8 text-left"> 
      <h1>Sign Up</h1>
      <hr>

      <?php if (isset($_SESSION['error'])) { ?>
        
        <h5 class="text-warning">* <?php echo $_SESSION['error']; ?></h5>
      
      <?php } ?>

        <form action="signup_handler.php" method="post">
          <div class="form-group">
            <label for="email">Username:</label>
            <input type="text" class="form-control" name="username">
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email">
          </div>
          <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" name="password">
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
      </form>
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
