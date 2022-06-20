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

if (isset($_POST['delete_song_id'])) {
		$song_id = $_POST['delete_song_id'];

		if (trim($song_id, " ") == "") {
			$invalid_req = "The search parameter is empty - nothing to delete.";
		} else {
				$query = mysqli_query($conn, "SELECT * FROM track3 WHERE id = '$song_id'");

				if (mysqli_num_rows($query) == 0) {
						$invalid_req = "The requested song does not match any in the database - unable to delete.";
				} else {
						$results = mysqli_fetch_assoc($query);

						$sql_cmd = "DELETE FROM track3 WHERE id = '$song_id'";
						if ($conn->query($sql_cmd) == TRUE) {
								$delete_msg = "~ SUCCESSFUL DELETION ~";
						} else {
								$invalid_req = "Deletion failed - " . $conn->error;
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
		<title>MUSE Demo - Delete</title>
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
            "<h3 style=\"text-decoration:underline\">DELETING THE SONG '" . $results['name'] . "'</h3>" .
            "<h4>Song ID: " . $results['id'] . "</h4>" .
            "<h4>Album: " . $results['album'] . "</h4>" .
            "<h4>Artist(s): " . trim($results['artists'], "\"[\'\']\"") . "</h4>" .
						"<p>" . $delete_msg . "</p>"
        ; ?>
    </div>

		<br />
		<br />

		<div class="footer">
        <p>MUSE Team 2021</p>
    </div>
</body>
</html>
