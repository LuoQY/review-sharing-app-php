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

  include("navigation.php"); 

?>
  
<div class="container-fluid text-center">    
  <div class="row content">

    <!--left bar-->
    <div class="col-sm-2 sidenav">

    </div>

    <!--center-->
    <div class="col-sm-8 text-left"> 
      <h1>Login</h1>
      <hr>

      <?php if (isset($_SESSION['error'])) { ?>
        
        <h5 class="text-warning">* <?php echo $_SESSION['error']; ?></h5>
      
      <?php } ?>

        <form action="login_handler.php" method="post">
          <div class="form-group">
            <label for="email">Username:</label>
            <input type="text" class="form-control" name="username">
          </div>
          <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" name="password">
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <h5>Don't have an account? <a href="signup.php">Sign up here</a></h5>
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
