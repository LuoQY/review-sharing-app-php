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
  if(!isset($_POST['username']) or !isset($_POST['password']) or empty($_POST['username']) or empty($_POST['password'])) {
    unset($_SESSION['error']);
    $_SESSION['error'] = "Please enter username and password";
    include("login.php");
  } else {

    $conn = mysqli_connect('localhost','root','', 'rottenpotatoes');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $sql = "SELECT password FROM users WHERE username='" . $_POST['username'] . "'";
    $response = $conn->query($sql);

    if (!$response) {
      $_SESSION['error'] = "Couldn't run the query";
      include("login.php");
    } else if(mysqli_num_rows($response) == 0) {
      $_SESSION['error'] = "Username is invalid! Please try again.";
      include("login.php");
    } else {
      while($row = $response->fetch_assoc()) {
        if($row['password'] != $_POST['password']) {
          $_SESSION['error'] = "Password is invalid! Please try again.";
          include("login.php");
        } else {
          $_SESSION['username'] = $_POST['username'];
          include("navigation.php"); 
          ?>
            
          <div class="container-fluid text-center">    
            <div class="row content">

              <!--left bar-->
              <div class="col-sm-2 sidenav">

              </div>

              <!--center-->
              <div class="col-sm-8 text-left"> 
                <h1>Welcome Back! <?php echo $_POST['username']; ?>.</h1>
                <hr>
                  
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
        }
      }
    }
  }

?>


</body>
</html>
