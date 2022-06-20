<?php

$servername = "localhost";
$username = "root";
$password = "stingrays";
$db = "muse";
$conn = NULL;

try {
		$conn = mysqli_connect($servername, $username, $password, $db);
} catch (PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
}

if (isset($_POST['insert_song_name'], $_POST['insert_album_name'], $_POST['insert_artist_name'], $_POST['insert_release_date'])) {
		$song_name = $_POST['insert_song_name'];
		$album_name = $_POST['insert_album_name'];
		$artist_name = $_POST['insert_artist_name'];
		$release_date = $_POST['insert_release_date'];

		if (trim($song_name, " ") == "" or trim($album_name, " ") == "" or
		trim($artist_name, " ") == "" or trim($release_date, " ") == "") {
				$invalid_req = "One or more search parameters are empty - unable to insert.";
		} else {
				$query = mysqli_query($conn, "SELECT * FROM track3 WHERE name = '$song_name' and album = '$album_name' and artists = '$artist_name' and release_date = '$release_date'");
			
				if (mysqli_num_rows($query) > 0) {
						$invalid_req = "The requested song is already in the database - unable to insert.";
				} else {
						// MAKE SURE NEW_ID IS NOT ALREADY IN THE DATABASE
						$new_id = rand();
						$check_id = mysqli_query($conn, "SELECT id FROM track3 WHERE id = '$new_id'");
						while (mysqli_num_rows($check_id) > 0) {
								$new_id = rand();
								$check_id = mysqli_query($conn, "SELECT id FROM track3 WHERE id = '$new_id'");
						}

						$sql_cmd = "INSERT INTO track3 SET id = '$new_id', name = '$song_name', album = '$album_name', artists = '$artist_name', track_number = '1', release_date = '$release_date';";
						if ($conn->query($sql_cmd) == TRUE) {
								$query = mysqli_query($conn, "SELECT name, album, artists, release_date FROM track3 WHERE name = '$song_name' and album = '$album_name' and artists = '$artist_name' and release_date = '$release_date'");
								$results = mysqli_fetch_assoc($query);
								$insert_msg = "~ SUCCESSFUL INSERTION ~";
						} else {
								$invalid_req = "Insertion failed - unable to insert.";
						}
				}
		}
}
else {
		header("Location: http://local.muse/");
		exit;
}	
$conn->close();

?>

<!--
Resources consulted:
	https://stackoverflow.com/questions/17388800/display-results-from-mysql-query-in-php
-->

<!DOCTYPE html>
<html>
<head>
		<link rel="icon" href="imgs/M_logo.png" type="image/icon type">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>MUSE Demo - Insert</title>
		<link rel="stylesheet" href="css/style.css">
</head>

<body>
		<header>
        <div class="container-h">
            <h1 class="logo">MUSE Demo - Delete</h1>
            <nav>
                <ul>
                    <li><a href="http://local.muse/demo.php">Return to Demo</a></li>
                </ul>
            </nav>
        </div>
        <div class="black-line"></div>
    </header>

		<br />
		<br />

		<div class="center-content-col">
        <?php echo (isset($invalid_req)) ? "<p>" . $invalid_req . "</p>" :
            "<h3 style=\"text-decoration:underline\">INSERTING THE SONG '" . $results['name'] . "'</h3>" .
            "<h4>Album: " . $results['album'] . "</h4>" .
            "<h4>Artist(s): " . trim($results['artists'], "\"[\'\']\"") . "</h4>" .
						"<h4>Release Date: " . $results['release_date'] . "</h4>" .
						"<p>" . $insert_msg . "</p>"
        ; ?>
    </div>

		<br />
		<br />

		<div class="footer">
        <p>MUSE Team 2021</p>
    </div>
</body>
</html>
