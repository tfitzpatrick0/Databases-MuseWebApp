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

if (isset($_POST['update_song_id'], $_POST['update_track_number'])) {
    $song_id = $_POST['update_song_id'];
    $new_track_num = $_POST['update_track_number'];

    if ((trim($song_id, " ") == "") or (trim($new_track_num, " ") == "")) {
        $invalid_req = "One or more search parameters are empty - unable to update.";
    } else {
        $song_name = mysqli_query($conn, "SELECT name FROM track3 WHERE id = '$song_id'");
        $old_track_num = mysqli_query($conn, "SELECT track_number FROM track3 WHERE id = '$song_id'");

        if ((mysqli_num_rows($song_name) == 0) or (mysqli_num_rows($old_track_num) == 0)) {
            $invalid_req = "The requested song does not match any in the database - unable to update.";
        } else {
            $results = array();
            array_push($results, mysqli_fetch_assoc($song_name));
            array_push($results, mysqli_fetch_assoc($old_track_num));

            mysqli_query($conn, "UPDATE track3 SET track_number=$new_track_num WHERE id = '$song_id'");
        }
    }
}
else {
    header("Location: http://local.muse/");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="imgs/M_logo.png" type="image/icon type">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MUSE Demo - Update</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <div class="container-h">
            <h1 class="logo">MUSE Demo - Update</h1>
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
            "<h3 style=\"text-decoration:underline\">UPDATING THE SONG '" . $results[0]['name'] . "'</h3>" .
            "<h4>Song ID: " . $song_id . "</h4>" .
            "<h4>Old Track Number: " . $results[1]['track_number'] . "</h4>" .
            "<h4>New Track Number: " . $new_track_num . "</h4>"
        ; ?>
    </div>

    <br />
    <br />

    <div class="footer">
        <p>MUSE Inc.</p>
    </div>
</body>
</html>
