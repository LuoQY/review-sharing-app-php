<html>
<body>
<ul>
<?php
$conn = mysqli_connect('localhost','root','', 'rottenpotatoes');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, movie FROM reviews";
$response = $conn->query($sql);

if (!$response) {
  die('<p>Error retrieving reviews from database!<br />'.
      'Error: ' . mysqli_connect_error() . '</p>');
}

 while($row = $response->fetch_assoc()) {
  $id   = $row['id'];
  $name = $row['movie'];
  echo("$id <br>");
  echo("$name <br>");
  
}

mysqli_close($conn);

?>
</ul>

</p>
</body>
</html>