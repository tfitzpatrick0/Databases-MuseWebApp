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

if (isset($_POST['searched_song_name'])) {
		$song_name = $_POST['searched_song_name'];
		if (trim($song_name, " ") == "") {
				$empty_param = "The search parameter is empty - displaying the first 300 entries.";
				$query = mysqli_query($conn, "SELECT * FROM track3 LIMIT 300");
		} else {
				$query = mysqli_query($conn, "SELECT * FROM track3 WHERE name = '$song_name'");
		}
		$results = array();
		while($row = mysqli_fetch_assoc($query)) {
				array_push($results, $row);
		}
}
$conn->close();

?>

<!-- 
Resources consulted:
	https://stackoverflow.com/questions/17388800/display-results-from-mysql-query-in-php
	https://stackoverflow.com/questions/55018495/php-mysql-display-table-with-action-row-clickable-to-open-specific-file
-->

<!DOCTYPE html>
<html>
<head>
		<link rel="icon" href="bkgs/M_logo.png" type="image/icon type">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>MUSE Demo - Search</title>
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">

		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js" type="text/javascript" charset="utf8"></script>
</head>
<body>
		<header>
        <div class="container-h">
            <h1 class="logo">MUSE Demo - Search</h1>
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

		<div class="search-container">
				<p><?php echo (isset($empty_param)) ? $empty_param : '';?></p>
				<table id="songTable"></table>
		</div>

		<script type="text/javascript">
				var searchResults = <?php echo json_encode($results); ?>;
				$('#songTable').DataTable({
						data: searchResults,
						columns: [
								{"title": "Song Name", "data": "name"},
								{"title": "Song ID", "data": "id"},
								{"title": "Album", "data": "album"},
								{"title": "Duration", "data": "duration_ms"},
								{"title": "Year", "data": "year"}
						]
				});
		</script>

		<br />
		<br />

		<div class="footer">
        <p>MUSE Team 2021</p>
    </div>
</body>
</html>
