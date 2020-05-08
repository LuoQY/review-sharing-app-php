<head>
  <title>Rotten Potatoes</title>
</head>
<body>
	<?php
		$conn = mysqli_connect('localhost','root','', 'rottenpotatoes');
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		//clear database 
		$sql_clear = "DELETE FROM suggestions";
		$response = $conn->query($sql_clear);
		if ($response == FALSE) {
			die('<p>Error Cannot clear the suggestions table<br />'.
			   'Error: ' . mysqli_connect_error() . '</p>');
		}


		$sql = "SELECT id FROM reviews";
		$response = $conn->query($sql);

		if (!$response) {
		  	die('<p>Error retrieving reviews from database!<br />'.
		      	'Error: ' . mysqli_connect_error() . '</p>');
		}

		while($row = $response->fetch_assoc()) {
		  	$id = $row['id'];
		  	$related_review = [];
		  	// get a list of Person who likes this review
		  	$sql_get_person = "SELECT username FROM user_likes WHERE review_id=" . $id;
		  	$users = $conn->query($sql_get_person);
		  	if (!$users) {
				  die('<p>Error retrieving users from table user_likes!<br />'.
			  	    'Error: ' . mysqli_connect_error() . '</p>');
		  	}
			// for each person, get a list of reviews he/she liked
			while ($user = $users->fetch_assoc()) {
		  		$sql_get_content = "SELECT review_id FROM user_likes WHERE username='" . $user['username'] . "'";
		  		$content = $conn->query($sql_get_content);
		  		if (!$content) {
		  			die('<p>Error retrieving review id from table user_likes!<br />'.
			  	    	'Error: ' . mysqli_connect_error() . '</p>');
		  		}
		  		
		  		while ($re = $content->fetch_assoc()) {
		  			if ($re['review_id'] != $id) {
		  				array_push($related_review, $re['review_id']);
		  			}
		  		}
			}

			//save the suggestions to database
			if(count($related_review) != 0) {
				$str = "";
				foreach ($related_review as $value) {
					$str .= $value . " ";
				}
				$sql_save = "INSERT INTO suggestions(review_id, related_id) VALUES (" . $id . ",'" . $str . "')";
				$res = $conn->query($sql_save);
			  	if (!$res) {
					  die('<p>Error saving id to table suggestions!<br />'.
				  	    'Error: ' . mysqli_connect_error() . '</p>');
			  	}
			}
		}
		echo "Suggestion Updating Done!";
		mysqli_close($conn);
	?>
</body>