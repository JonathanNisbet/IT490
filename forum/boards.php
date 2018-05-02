<?php
  $app_id = $_GET["gameid"];

  $options = array('http' => array('user_agent' => 'custom user agent string'));
  $context = stream_context_create($options);
  $apiResult = file_get_contents("https://www.giantbomb.com/api/game/3030-".$app_id."/?api_key=1eb68d69b5b8c3a4d37f93116ba4968ccf789a33&format=json&resources=game", false, $context);
  $json = json_decode($apiResult);
?>

<?php
session_start();

// Check if user is logged in using the session variable
if ( $_SESSION['logged_in'] != 1 ) {
  $_SESSION['message'] = "You must log in first!";
  header("location: error.php");
}
else {
    // Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
}
?>

<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>


  <title>Forum for <?php echo $json->results->name; ?></title>

  <?php include '../css/css.html'; ?>

  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <div class="form">

	<h1>Forum for <?php echo $json->results->name; ?></h1>
  <h2>Boards</h2><br>
  <table>
    <tr><th>Title</th><th>Topics</th></tr>

    <?php

    $forum = new mysqli('localhost', 'root', 'Jonathan723', 'forum');

    $sql = "SELECT count(*) FROM `$app_id"."_topics` WHERE `board_id` = 1";
    $result = $forum->query($sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count = $row["count(*)"];

    echo "<tr><td><a href='general.php?gameid=".$app_id."'>General Discussion</td><td>";

    if ($count > 0){
      echo $count."</td></tr></table>";
    }
    else{
      echo "0</td></tr></table>";
    }

    echo "<br><a href='../game.php?gameid=".$app_id."'><button class='button button-block' name='profile'/>Back to game</button></a>";

    ?>

   <br><a href="../profile.php"><button class="button button-block" name="profile"/>Back to profile</button></a>


<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="../js/index.js"></script>

</body>
</html>
