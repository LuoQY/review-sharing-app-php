<head>
  <title>Rotten Potatoes</title>
</head>
<body>
	<?php

		// connect to database
		$conn = mysqli_connect('localhost','root','', 'rottenpotatoes');
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		// get the relationship between users and content
		$sql = "SELECT * FROM user_likes";
		$response = $conn->query($sql);

		if (!$response) {
			die('<p>Error retrieving user_likes from database!<br />'.
			   'Error: ' . mysqli_connect_error() . '</p>');
		}

		// aggregate the reviews based on username
		$likes_arr = [];
		while($row = $response->fetch_assoc()) {
		  	$username = $row['username'];
		  	if (array_key_exists($username, $likes_arr)) {
		  		array_push($likes_arr[$username], $row['review_id']);
		  	} else {
		  		$ids = [];
		  		array_push($ids, $row['review_id']);
		  		$likes_arr[$username] = $ids;
		  	}
		}

		//clear database 
		$sql_clear = "DELETE FROM vector";
		$response = $conn->query($sql_clear);
		if ($response == FALSE) {
			die('<p>Error Cannot clear the vector table<br />'.
			   'Error: ' . mysqli_connect_error() . '</p>');
		}

		// for each user, get their favorite reviews and build the word vector
		foreach ($likes_arr as $user => $id_arr) {
			$vector = [];
			$count = 0;
			// get the frequency of words in every review
			foreach ($id_arr as $review_id) {
				$sql = "SELECT content FROM reviews WHERE id=" . $review_id;
				$response = $conn->query($sql);
				if (!$response) {
					die('<p>Error retrieving reviews from database!<br />'.
					   'Error: ' . mysqli_connect_error() . '</p>');
				}
				while($row = $response->fetch_assoc()) {
					$str = $row['content'];
					$tokens = tokenize_and_remove_common_words($str);
					foreach ($tokens as $word) {
						if (array_key_exists($word, $vector)) {
					  		$vector[$word] += 1;
					  	} else {
					  		$vector[$word] = 1;
					  	}
					  	$count++;
					}
				}
			}
			// store word vector as a string to database
			$vector_str = "";
			foreach ($vector as $w => $freq) {

				$rescale = $freq / $count;
				$vector_str .= $w . " " . $rescale . ",";
			}
			$sql = "INSERT INTO vector(username, vector) VALUES ('" . $user . "', '" . $vector_str . "')";
			$response_insert = $conn->query($sql);
		}

		echo "User Profile Vector Calculating Done";

		mysqli_close($conn);


		function tokenize_and_remove_common_words($string) {
			// tokenization
			$str = "";
			foreach (str_split($string) as $char) {
			  if (is_numeric($char) or preg_match('/[\.\'^£$%&*:()}{@#~?!><>,|=_+¬-]/', $char)) {
			    $str = $str . " ";
			  } else {
			    $str = $str . $char;
			  }
			}

			$chunks = explode(" ", $str);
			// remove common words
			$common_words = array("a", "about", "after", "all", "also", "an", "and", "any", "as", "at", "back", "be", "because", "but", "by", "can", "come", "could", "day", "do", "even", "first", "for", "from", "get", "give", "go", "good", "have", "he", "her", "him", "his", "how", "I", "if", "in", "into", "it", "its", "just", "know", "like", "look", "make", "me", "most", "my", "new", "no", "not", "now", "of", "on", "one", "only", "or", "other", "our", "out", "over", "people", "say", "see", "she", "so", "some", "take", "than", "that", "the", "their", "them", "then", "there", "these", "they", "think", "this", "time", "to", "two", "up", "us", "use", "want", "way", "we", "well", "what", "when", "which", "who", "will", "with", "work", "would", "year", "you", "your", "is", "are");

			$keywords = [];
			foreach ($chunks as $word) {
			  if (!in_array(strtolower($word), $common_words) and trim($word)!="") {
			    array_push($keywords, $word);
			  }
			}
			return $keywords;
		}
		

	?>
</body>