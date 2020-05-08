
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
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                        
        </button>
        <a class="navbar-brand" href="rottenpotatoes.php">R<span class="glyphicon glyphicon glyphicon-adjust"></span>tten Potatoes</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="submit_review.php"><span class="glyphicon glyphicon-pencil"></span> Write a Review</a></li>
          <li><a href="search.php"><span class="glyphicon glyphicon-search"></span> Search Reviews</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <?php 
            if (!isset($_SESSION['username'])) { ?>
              <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Log in</a></li>
              <li><a href="signup.php"><span class="glyphicon glyphicon-list-alt"></span> Sign up</a></li>
          <?php } else { ?>
              <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['username'] ?></a></li>
              <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>

</body>
</html>