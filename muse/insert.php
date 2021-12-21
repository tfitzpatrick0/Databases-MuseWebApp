<!DOCTYPE html>
<!--
Resources consulted:
	https://stackoverflow.com/questions/17388800/display-results-from-mysql-query-in-php
-->
<head>
	<title>Insert Page - Muse</title>
	<meta charset = "UTF-8">
</head>
<body>
	<?php

		$servername = "localhost";
		$username = "hjeon";
		$password = "na0103Yeh|";
		$db = "hjeon";
		$conn = NULL;

		try {
			$conn = mysqli_connect($servername, $username, $password, $db);
	//		echo "Connection successful";
		} catch (PDOException $e) { }
	?>
	<?php
//		echo $_POST['insert_song_name'];
//   		echo $_POST['insert_album_name'];
//		echo $_POST['insert_artist_name'];
//		echo $_POST['insert_release_date'];
		//if ($_REQUEST["button"] == "Insert") {
		if (isset($_POST['insert_song_name'], $_POST['insert_album_name'], $_POST['insert_artist_name'], $_POST['insert_release_date'])) {
			$song_name = $_POST['insert_song_name'];
			$album_name = $_POST['insert_album_name'];
			$artist_name = $_POST['insert_artist_name'];
			$release_date = $_POST['insert_release_date'];
			if (trim($song_name, " ") == "" or trim($album_name, " ") == "" or
			trim($artist_name, " ") == "" or trim($release_date, " ") == "") {
				echo "All four attributes should be provided!!!!";
			} else {
				$sql_cmd = "SELECT * FROM track3 WHERE name = '$song_name' and album = '$album_name'";
				$query = mysqli_query($conn, $sql_cmd);
				$count = mysqli_num_rows($query);
				if ($count > 0) {
					echo "Song already exists in database";
				} else {
					//TODO: find way to generate a new_id that is not already in the database
					$new_id = rand();
				$sql_cmd = "INSERT INTO track3 SET id = '$new_id', name = '$song_name', album = '$album_name', artists = '$artist_name', track_number = '12345', release_date = '$release_date';";
			echo "Checking insertion...";
					if ($conn->query($sql_cmd) == TRUE) {
						echo "\r\n";
						echo "Resulting song information added";
						$sql_cmd = "SELECT name, album, artists, release_date FROM track3 WHERE name = '$song_name' and album = '$album_name' and artists = '$artist_name' and release_date = '$release_date'";
						//TODO: change size of release_date to greater varchar
						// i.e. 11/02/21 as opposed to 11/2/21 problem
						$query = mysqli_query($conn, $sql_cmd);
						echo "<table border='1'><tr><th>Song Title</th><th>Song ID</th><th>Album</th><th>Artists</th></tr>";
						$row = mysqli_fetch_assoc($query);
						echo "<tr>";
						echo "<td>" . $row['name'] . "</td>";
						echo "<td>" . $row['album'] . "</td>";
						echo "<td>" . trim($row['artists'], "\"[\'\']\"") . "</td>";
						echo "<td>" . $row['release_date'] . "</td>";
						echo "</tr>";
						echo "</table>";
					} else {
						echo "Insertion not successful";
					}
				}
			}
		}
		echo "<br/>";
		echo "<a href = 'http://db.cse.nd.edu/cse30246/muse/demo.php'>Back to demo.php</a>";
//		}
		$conn->close();

	?>

</body>
</html>
