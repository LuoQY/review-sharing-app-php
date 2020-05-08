<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<html>
<head>
<title>Rotten Potatoes</title>
</head>
<body>

<?php

class ReviewShow {
	public $content;
	public $rate;
	public $username;
	public $date;
  public $movie;
  public $like;
  public $id;

 	function set_content($con) {
 		$this->content = $con;
 	}

 	function set_rate($ra) {
 		$this->rate = $ra;
 	}

 	function set_username($user) {
 		$this->username = $user;
 	}

 	function set_date($d) {
 		$this->date = $d;
 	}

  function set_movie($m) {
    $this->movie = $m;
  }

  function set_like($l) {
    $this->like = $l;
  }

  function set_id($i) {
    $this->id = $i;
  }
 }

function getPanel(string $username, string $rate, string $movie, string $date, string $content, string $like, string $id) {
  if (isset($_SESSION['username'])) {
    return "<div class=\"panel panel-warning\">
              <div class=\"panel-heading\">" . $username . " | Rating: " . $rate ."/10 | " . $movie ."
                <span style=\"float:right;\">" . $date . "</span>
              </div>
              <div class=\"panel-body\">" . $content . "</div>
              <div class=\"panel-footer\">
                <button class=\"btn btn-warning\" name=\"likebtn\" onclick=\"btnDisable(this," . $id . ",'" . $_SESSION['username'] . "')\" id=\"likebtn\">Like it! </button>
                <span style=\"float:right;\">" . $like . " likes</span>
              </div>
            </div>
          </br>";
  } else {
    return "<div class=\"panel panel-warning\">
              <div class=\"panel-heading\">" . $username . " | Rating: " . $rate ."/10 | " . $movie ."
                <span style=\"float:right;\">" . $date . "</span>
              </div>
              <div class=\"panel-body\">" . $content . "</div>
              <div class=\"panel-footer\">
                <button class=\"btn btn-warning\" name=\"likebtn\" id=\"likebtn\" disabled>Like it! </button>
                <span style=\"float:right;\">" . $like . " likes</span>
              </div>
            </div>
          </br>";
  }
    
}


$reviews_arr = [];

// tokenization
$str = "";
foreach (str_split($_POST['search']) as $char) {
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
  if (!in_array(strtolower($word), $common_words)) {
    array_push($keywords, $word);
  }
}
//echo implode(", ", $keywords);

$message = "";

if(count($keywords) == 0) {
  $message = "<h4>Sorry, we couldn't find any reviews for: <mark>" . $_POST['search'] . "</mark></h4>";
  goto end;
}


$conn = mysqli_connect('localhost','root','', 'rottenpotatoes');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// construct sql query
// AND
$sql = "SELECT * FROM reviews WHERE ";
for($i = 0; $i < count($keywords); $i++) {
  $sql = $sql . "movie like '%" . $keywords[$i] . "%' ";
  if($i != count($keywords) - 1) {
    $sql = $sql . "AND ";
  }
}

$sql = $sql . "ORDER BY datetime DESC";

if (!isset($_SESSION['username'])) {
  $sql = $sql . " limit 3";
}


//echo $sql;

//$sql = "SELECT * FROM reviews WHERE movie='" . $_POST['search'] . "' ORDER BY datetime DESC";
$response = $conn->query($sql);


if ($response) {
	while($row = $response->fetch_assoc()) {
		$review = new ReviewShow();
		$review->set_content($row['content']);
		$review->set_rate($row['rate']);
		$review->set_username($row['username']);
		$review->set_date($row['datetime']);
    $review->set_movie($row['movie']);
    $review->set_like($row['likes']);
    $review->set_id($row['id']);
		array_push($reviews_arr, $review);
	}
}


//OR
$sql = "SELECT * FROM reviews WHERE ";
for($i = 0; $i < count($keywords); $i++) {
  $sql = $sql . "movie like '%" . $keywords[$i] . "%' ";
  if($i != count($keywords) - 1) {
    $sql = $sql . "OR ";
  }
}
$sql = $sql . "ORDER BY datetime DESC";

if (!isset($_SESSION['username'])) {
  $sql = $sql . " limit 3";
}

//echo $sql;

//$sql = "SELECT * FROM reviews WHERE movie='" . $_POST['search'] . "' ORDER BY datetime DESC";
$response = $conn->query($sql);

if ($response){
  while($row = $response->fetch_assoc()) {
    $review = new ReviewShow();
    $review->set_content($row['content']);
    $review->set_rate($row['rate']);
    $review->set_username($row['username']);
    $review->set_date($row['datetime']);
    $review->set_movie($row['movie']);
    $review->set_like($row['likes']);
    $review->set_id($row['id']);
    array_push($reviews_arr, $review);
  }
}

// show all the related reviews to users and three reviews to visitors
if(count($reviews_arr) != 0) {
  if (isset($_SESSION['username'])) {
    $reviews_arr = sort_reviews_by_favorite($reviews_arr, $conn);
    $top_review = array_values($reviews_arr)[0];
  }
  $content_arr = [];
  $i = 0;
  foreach ($reviews_arr as $r) {
    if(in_array($r->content, $content_arr) or $i >= 3) {
      continue;
    }
    $message = $message . getPanel($r->username,$r->rate,$r->movie,$r->date,$r->content,$r->like, $r->id);
    array_push($content_arr, $r->content);
    if(!isset($_SESSION['username'])) {
      $i++;
    }
    
  }
  if(!isset($_SESSION['username'])) {
    $message = $message . "<div class=\"well well-lg\"><i class=\"glyphicon glyphicon-lock\"></i><a href=\"login.php\">  Login</a> to see more reviews.</div>";
  }
}


end:
if(empty($message)) {
  $message = "<h4>Sorry, we couldn't find any reviews for: <mark>" . $_POST['search'] . "</mark></h4>";

} else {
  $message = "<h4>Critic reviews for: <mark>" . $_POST['search'] . "</mark></h4><hr>" . $message;
}

// get the related content of the top review
if(isset($top_review)) {
  $message .= "<hr><h4>Recommendation for you:</h4>";
  $suggestions = get_suggestion($top_review->id, $conn);
  if($suggestions != null) {
    foreach ($suggestions as $suggestion) {
      if(!id_is_in_review_arr($suggestion, $reviews_arr)) {
        $sql = "SELECT * FROM reviews WHERE id=" . $suggestion;
        $res = $conn->query($sql);
        if ($res) {
          while($row = $res->fetch_assoc()) {
            $sug_review = new ReviewShow();
            $sug_review->set_content($row['content']);
            $sug_review->set_rate($row['rate']);
            $sug_review->set_username($row['username']);
            $sug_review->set_date($row['datetime']);
            $sug_review->set_like($row['likes']);
            $sug_review->set_movie($row['movie']);
            $message = $message . getPanel($row['username'],$row['rate'],$row['movie'],$row['datetime'],$row['content'], $row['likes'], $row['id']);
          }
        }
        break;
      }
    }
  }
  if (!isset($sug_review)) {
    $sql = "SELECT * FROM reviews ORDER BY datetime DESC LIMIT 3";
    $response = $conn->query($sql);
    if($response) {
      while($row = $response->fetch_assoc()) {
        $message = $message . getPanel($row['username'],$row['rate'],$row['movie'],$row['datetime'],$row['content'], $row['likes'], $row['id']);
        
      }
    }
  }
}


mysqli_close($conn);

function id_is_in_review_arr($id, $arr) {
  foreach ($arr as $review) {
    if ($id == $review->id) {
      return true;
    }
  }
  return false;
}


function sort_reviews_by_favorite($review_arr, $conn) {
  // get vector from database
  $sql_get_vector = "SELECT vector FROM vector WHERE username='" . $_SESSION['username'] . "'";
  $result = $conn->query($sql_get_vector);
  if($result) {
    $vector = [];
    while($row = $result->fetch_assoc()) {
      $vec = $row['vector'];
    }
    // transfer the format of vector to array
    if (!isset($vec)) {
      return $review_arr;
    }
    $tokens = explode(",", $vec);
    foreach ($tokens as $token) {
      if ($token != "") {
        $pair = explode(" ", $token);
        $vector[$pair[0]] = (float)$pair[1];
      }
    }
    

    // calculate the score for each review
    $new_review_arr = [];
    $count = 0;
    foreach ($review_arr as $review) {
      $score = 0;
      $bgw = tokenize_and_remove_common_words($review->content);
      foreach ($bgw as $word) {
        if (array_key_exists($word, $vector)) {
          $score += $vector[$word];
        }
      }
      
      $hash_score = (int)($score * 100000);
      if ($hash_score == 0) {  // if the review get 0
        $new_review_arr[$count] = $review;
        $count--;
      } else if (array_key_exists($hash_score, $new_review_arr)) {  // if two reviews have the same score
        $key = $hash_score + 1;
        $new_review_arr[$key] = $review;
      } else {
        $new_review_arr[$hash_score] = $review;
      }
    }
    krsort($new_review_arr, 1);
    return $new_review_arr;
  }

  return $review_arr;
}



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

function get_suggestion($review_id, $conn) {
  $sql = "SELECT related_id FROM suggestions WHERE review_id=" . $review_id;
  $response = $conn->query($sql);
  $sugg = null;
  if($response) {
    while ($r = $response->fetch_assoc()) {
      $sugg = explode(" ", $r['related_id']);

    }
  }
  return $sugg;
}

    
?>

<?php include("navigation.php"); ?>
  
<div class="container-fluid text-center">    
  <div class="row content">

    <!--left bar-->
    <div class="col-sm-2 sidenav">

    </div>

    <!--center-->
    <div class="col-sm-8 text-left"> 
      <h1>Search</h1>
      <p>The most trusted measurement of quality for movies </p>
      <hr>
      <form action="search_handler.php" method="post">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search movies..." name="search">
          <div class="input-group-btn">
            <button class="btn btn-default" type="submit">
              <i class="glyphicon glyphicon-search"></i>
            </button>
          </div>
        </div>
      </form>
      <?php echo $message; ?>

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
<label id='demo'></label>

<script>
function btnDisable(btn, id, username) {
  btn.disabled = true;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == XMLHttpRequest.DONE) {
        document.getElementById("demo").innerHTML = xmlhttp.responseText;
    }
}
  xmlhttp.open("GET", "like_handler.php?id=" + id + "&username=" + username, true);
  xmlhttp.send();
}

</script>


</body>
</html>
