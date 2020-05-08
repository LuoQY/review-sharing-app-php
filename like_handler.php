<html>
<head>
<title> Title of the page </title>
</head>
</html>
<body>
	<?php 
	$id = $_GET["id"];

	if(isset($_GET["username"]) or !empty($_GET["username"]))
		$username = $_GET["username"];
	else
		echo "Can't get username";

	$conn = mysqli_connect('localhost','root','', 'rottenpotatoes');
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$sql = "UPDATE reviews SET likes = likes + 1 WHERE id=" . $id . ";";
	$sql .= "INSERT INTO user_likes (username, review_id) VALUES ('" . $username . "'," . $id . ");";
	echo $sql;
	if (!$conn->multi_query($sql)) {
    	echo "Multi query failed: (" . $conn->errno . ") " . $conn->error;
	}

?>
</body>