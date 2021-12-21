<?php
//session_destroy();
session_start();
if($_SESSION['loggedon'] != '1') {
	die(header('location:login.php'));
	//echo 'wrong credentials';
	exit;
}
$servername = "localhost";
$username = "hjeon";
$password = "na0103Yeh|";
$conn = NULL;

try {
    $conn = new PDO("mysql:host=$servername;dbname=hjeon", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="bkgs/M_logo.png" type="image/icon type">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Muse Modify</title>
    <link rel="stylesheet" href="css/sty.css">
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>

<body class="bkg_im">

    <header>
      <div class="container_h">
      <h3 class="logo">MUSE Edit Database</h3>

        <nav>
          <ul>
            <li><a href="http://db.cse.nd.edu/cse30246/muse/">Home</a></li>
            <li><a href="http://db.cse.nd.edu/cse30246/muse/devplan.html">DevPlan</a></li>
            <li><a href="http://db.cse.nd.edu/cse30246/muse/project.html">About</a></li>
            <li><a href="http://db.cse.nd.edu/cse30246/muse/login.php">Admin</a></li>
            <li><a href="http://db.cse.nd.edu/cse30246/muse/oauth.php">Login</a></li>
          </ul>
        </nav>
      </div>
    </header>

    <h1></h1>

    <div class="container-fluid">

      <div>
      <h3>Song Search:</h3>
      <form class="d-flex" action = "http://db.cse.nd.edu/cse30246/muse/search.php" method ="post">
      <input class="form-control me-2" type="text" name = "searched_song_name" placeholder="Enter the song name ..." aria-label="Search">
          <button class="btn btn-outline-success" type="submit" onclick="window.location.href = 'http://db.cse.nd.edu/cse30246/muse/search.php';">Search</button>
      </form>
      <br>
      #add search results here

      <h4>Update by Id</h4>
      <form action = "http://db.cse.nd.edu/cse30246/muse/update.php" method="post">
          <input class="form-control me-2" type="text" name = "update_song_id" placeholder="Enter song ID..." aria-label="Search">
          <input class="form-control me-2" type="text" name = "update_track_number" placeholder="Enter track number..." aria-label="Track num">

          <button type="submit" class="btn btn-outline-success"
          onclick="window.location.href = 'http://db.cse.nd.edu/cse30246/muse/update.php';">
          Update
          </button>
      </form>

      <br>

      <h4>Delete by Id</h4>
      <form action = "http://db.cse.nd.edu/cse30246/muse/delete.php" method = "post">
      <input class="form-control" id="deleteId" name = "song_id_to_delete" type="text" placeholder="Song id" aria-label="default input delete">
      <button type="submit" class="btn btn-outline-success" onclick="window.location.href = 'http://db.cse.nd.edu/cse30246/muse/delete.php';">Delete</button>
      </form>
      <br>
      <br>

      <h4>Insert New Song</h4>
      <form action = "http://db.cse.nd.edu/cse30246/muse/insert.php" method = "POST">
          <input class="form-control" name = "insert_song_name" type="text" placeholder="Song name" aria-label="default input name"/>
          <input class="form-control" name = "insert_album_name" type="text" placeholder="Album" aria-label="default input album"/>
          <input class="form-control" name = "insert_artist_name" type="text" placeholder="Artist" aria-label="default input artist"/>
          <input class="form-control" name = "insert_release_date" type="text" placeholder="Release date" aria-label="default input release date"/>

      <button class="btn btn-outline-success" type="submit" onclick = "window.location.href = 'http://db.cse.nd.edu/cse30246/muse/insert.php';">Insert</button>
      </form>
    </div>

<br>

  </div>

</body>

</html>
