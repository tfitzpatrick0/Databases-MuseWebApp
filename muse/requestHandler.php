<?php
		$servername = "localhost";
		$username = "root";
		$password = "stingrays";
		$db = "muse";
		$conn = NULL;

		try {
			$conn = mysqli_connect($servername, $username, $password, $db);
		} catch (PDOException $e) { }
	
        
		if (isset($_POST['searched_song_name'])) {
			$song_name = $_POST['searched_song_name'];
			if (trim($song_name, " ") == "") {
				echo "Note that results are truncated because searched title is blank";
				$query = mysqli_query($conn, "SELECT * FROM track3 LIMIT 300");
				//$query = mysqli_query($conn, "SELECT * FROM tracks_features LIMIT 300");
			} else {
				$query = mysqli_query($conn, "SELECT * FROM track3 WHERE name = '$song_name'");
				//$query = mysqli_query($conn, "SELECT * FROM tracks_features WHERE name = '$song_name'");
			}
			$results = array();
			while($row = mysqli_fetch_assoc($query)) {
				array_push($results, $row);
			}
      echo json_encode($results);
    }
