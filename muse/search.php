<!DOCTYPE html>
<!-- 
Resources consulted:
	https://stackoverflow.com/questions/17388800/display-results-from-mysql-query-in-php
	https://stackoverflow.com/questions/55018495/php-mysql-display-table-with-action-row-clickable-to-open-specific-file
-->
<head>
	<link rel="icon" href="bkgs/M_logo.png" type="image/icon type">
	<title>Search Page - Muse</title>
	<meta charset = "UTF-8">
	<link rel="stylesheet" href="css/sty.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">

	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
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
		} catch (PDOException $e) { }
	?>
	<?php

		if (isset($_POST['searched_song_name'])) {
			$song_name = $_POST['searched_song_name'];
			if (trim($song_name, " ") == "") {
				echo "Note that results are truncated because searched title is blank";
				$query = mysqli_query($conn, "SELECT * FROM track3 LIMIT 300");
			} else {
				$query = mysqli_query($conn, "SELECT * FROM track3 WHERE name = '$song_name'");
			}
			$results = array();
			while($row = mysqli_fetch_assoc($query)) {
				array_push($results, $row);
			}

			/*
			echo "<table border='1'><tr><th>Song Title</th><th>Song ID</th><th>Album</th><th>Artists</th><th>Track Number</th><th>Release Date</th></tr>";
			
			while($row = mysqli_fetch_assoc($query)) {
				echo "<tr>";
				//TODO: need to pass over $row['id'] to song.php
				echo "<td><a target='_blank' href='song.php?song_id=". $row['id'] ."'>" . $row['name'] . "</a></td>";
				//echo "<td>" . $row['name'] . "</td>";
				echo "<td>" . $row['id'] . "</td>";
				echo "<td>" . $row['album'] . "</td>";
				echo "<td>" . trim($row['artists'], "\"[\'\']\"") . "</td>";
				echo "<td>" . $row['track_number'] . "</td>";
				echo "<td>" . $row['release_date'] . "</td>";
				echo "</tr>";
			}
			echo "</table>";
			*/

		}
		$conn->close();

	?>
	<div>
		<table id="songTable" class="display"></table>
	</div>
	<script type="text/javascript">
		var searchTable = <?php echo json_encode($results); ?>;
		// console.log(searchTable);
		$('#songTable').DataTable({
			data: searchTable,
			columns: [
				{"title": "Song Name", "data": "name"},
				{"title": "Song ID", "data": "id"},
				{"title": "Album", "data": "album"},
				{"title": "Duration", "data": "duration_ms"},
				{"title": "Year", "data": "year"}
			]
		});
		
	</script>
	<br/>
	<a href = 'http://db.cse.nd.edu/cse30246/muse/demo.php'>Back to demo.php</a>
</body>
</html>
