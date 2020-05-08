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

  if(!isset($_POST['username']) or !isset($_POST['email']) or !isset($_POST['password']) or empty($_POST['username']) or empty($_POST['email']) or empty($_POST['password'])) {
    unset($_SESSION['error']);
    $_SESSION['error'] = "Please enter username, email and password";
    include("signup.php");
  } else {
    $conn = mysqli_connect('localhost','root','', 'rottenpotatoes');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE username='" . $_POST['username'] . "'";
    $response = $conn->query($sql);

    if(mysqli_num_rows($response) != 0) {
      $_SESSION['error'] = "Sorry, the username already exists. Please choose another name.";
      include("signup.php");
    }  else {
      $sql_insert = "INSERT INTO users (username, password, email) VALUES ('" . $_POST['username'] . "', '" . $_POST['password'] . "', '" . $_POST['email'] . "')";

      $response = $conn->query($sql_insert);

      if ($response == TRUE) { 
        
        $_SESSION['username'] = $_POST['username'];
        unset($_SESSION['error']);
        include("navigation.php"); 

        ?>
          
        <div class="container-fluid text-center">    
          <div class="row content">

            <!--left bar-->
            <div class="col-sm-2 sidenav">

            </div>

            <!--center-->
            <div class="col-sm-8 text-left"> 
              <h2>Congratulations! You are a member of Rotten Potatoes! </h2>
              <hr>
              <h4> The things you can do:</h4>
              <h5>&nbsp;&nbsp;&nbsp;&nbsp;- Write a review</h5>
              <h5>&nbsp;&nbsp;&nbsp;&nbsp;- Read reviews without limitation</h5>
              <h5>&nbsp;&nbsp;&nbsp;&nbsp;- Have a profile page</h5>
              <h5>&nbsp;&nbsp;&nbsp;&nbsp;- Mark a review</h5>
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

        
      <?php 
      
      } else {
        $_SESSION['error'] = "Couldn't insert the values";
        include("signup.php");
      }
    }
  }

  ?>


</body>
</html>