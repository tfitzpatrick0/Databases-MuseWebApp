<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Muse Update</title>
    <link rel="stylesheet" href="css/sty.css">
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>

<body class="bkg_im" onload="fetch_id()">

  <?php
    $servername = "localhost";
		$username = "root";
		$password = "stingrays";
		$db = "muse";
    $conn = NULL;

    try {
      $conn = mysqli_connect($servername, $username, $password, $db);
    } catch (PDOException $e) { }
  ?>

  <header>
    <div class="container_h">
      <h3 class="logo">MUSE Update</h3>

        <nav>
          <ul>
            <li><a href="http://local.muse/">Home</a></li>
            <li><a href="http://local.muse/devplan.html">DevPlan</a></li>
            <li><a href="http://local.muse/project.html">About</a></li>
            <li><a href="http://local.muse/login.php">Admin</a></li>
            <li><a href="http://local.muse/oauth.php">Login</a></li>

          </ul>
        </nav>
      </div>
    </header>

    <h1></h1>
<div>
  <div class="container-fluid">
    <div>
      <h4>Update [Song Name]</h4>

        <?php
          if (isset($_POST['update_song_id']) and isset($_POST['update_track_number'])) {
            $song_id = $_POST['update_song_id'];
            $new_track_num = $_POST['update_track_number'];

            echo "<h4>Song ID: $song_id</h4>";
            echo "<div></div>";
            echo "<h4>New Track Num: $new_track_num</h4>";

            echo "<h4>Updating track number...</h4>";
            mysqli_query($conn, "UPDATE track3 SET track_number=$new_track_num WHERE id='$song_id'");
          }
        ?>

      <br>
      <a href = 'http://local.muse/demo.php'>Back to demo.php</a>
    </div>
  </div>
  <div class="footer">
    <p>MUSE Inc.</p>
  </div>
</div>

</body>
</html>
