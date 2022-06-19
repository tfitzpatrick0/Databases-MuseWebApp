<!DOCTYPE html>
<!--
Resources consulted:
	https://stackoverflow.com/questions/17388800/display-results-from-mysql-query-in-php
-->
<head>
	<link rel="icon" href="bkgs/M_logo.png" type="image/icon type">
	<title>Delete Page - Muse</title>
	<meta charset = "UTF-8">
</head>
<body>
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
	<?php
		echo $_POST['delete_song_id'];
		if (isset($_POST['delete_song_id'])) {
			$song_id = $_POST['delete_song_id'];
			if (trim($song_id, " ") == "") {
				header("Location: http://local.muse/demo.php");
				exit;
			} else {
				$query = mysqli_query($conn, "SELECT * FROM track3 WHERE id = '$song_id'");
				$count = mysqli_num_rows($query);
				if ($count == 0) {
					//TODO: display error message "No ID  matches $song_id"
					echo "<h1>No ID matches $song_id</h1>";
					header("Location: http://local.muse/demo.php");
				} else {
					echo "To Be Deleted";
					echo "<table border='1'><tr><th>Song Title</th><th>Song ID</th><th>Album</th><th>Artists</th></tr>";
					$row = mysqli_fetch_assoc($query);
					echo "<tr>";
					echo "<td>" . $row['name'] . "</td>";
					echo "<td>" . $row['id'] . "</td>";
					echo "<td>" . $row['album'] . "</td>";
					echo "<td>" . trim($row['artists'], "\"[\'\']\"") . "</td>";
					echo "</tr>";
					echo "</table>";

					$sql_cmd = "DELETE FROM track3 WHERE id = '$song_id'";
					if ($conn->query($sql_cmd) == TRUE) {
						echo "Successful deletion";
					} else {
						echo "Deletion did not work" . $conn->error;
					}
				}
			}
		}
		$conn->close();

	?>

</body>
</html>
