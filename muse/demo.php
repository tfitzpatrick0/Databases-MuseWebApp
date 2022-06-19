<?php

session_start();
if($_SESSION['loggedon'] != '1') {
    die(header('location:login.php'));
    exit;
}

$servername = "localhost";
$username = "root";
$password = "stingrays";
$conn = NULL;

try {
    $conn = new PDO("mysql:host=$servername;dbname=muse", $username, $password);
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
    <title>Muse Demo</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <div class="container-h">
            <h1 class="logo">MUSE Demo</h1>
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
        <div class="black-line"></div>
    </header>

    <br />

    <div class="search-container">
        <div>
            <h1>Search Songs:</h1>
        </div>
        <form action="http://local.muse/search.php" method="post">
            <div class="search-form-container">
                <input class="input-text-field search-input-text" type="text" name="searched_song_name" placeholder="Enter the song name...">
                <button class="button standard-button" type="submit" onclick="window.location.href = 'http://local.muse/search.php'">Search</button>
            </div>
        </form>
    </div>

    <div class="search-container">
        <div>
            <h1>Update by ID:</h1>
        </div>
        <form action="http://local.muse/update.php" method="post">
            <div class="search-form-container">
                <input class="input-text-field search-input-text" type="text" name="update_song_id" placeholder="Enter the song ID...">
                <input class="input-text-field search-input-text" type="text" name="update_track_number" placeholder="Enter the new track number...">
                <button class="button standard-button" type="submit" onclick="window.location.href = 'http://local.muse/update.php'">Update</button>
            </div>
        </form>
    </div>

    <div class="search-container">
        <div>
            <h1>Delete by ID:</h1>
        </div>
        <form action="http://local.muse/delete.php" method="post">
            <div class="search-form-container">
                <input class="input-text-field search-input-text" type="text" name="delete_song_id" placeholder="Enter the song ID...">
                <button class="button standard-button" type="submit" onclick="window.location.href = 'http://local.muse/delete.php'">Delete</button>
            </div>
        </form>
    </div>

    <div class="search-container">
        <div>
            <h1>Insert New Song:</h1>
        </div>
        <form action="http://local.muse/insert.php" method="post">
            <div class="search-form-container">
                <input class="input-text-field search-input-text" type="text" name="insert_song_name" placeholder="Enter the song name...">
                <input class="input-text-field search-input-text" type="text" name="insert_album_name" placeholder="Enter the album...">
                <input class="input-text-field search-input-text" type="text" name="insert_artist_name" placeholder="Enter the artist...">
                <input class="input-text-field search-input-text" type="text" name="insert_release_date" placeholder="Enter the release year...">
                <button class="button standard-button" type="submit" onclick="window.location.href = 'http://local.muse/insert.php'">Insert</button>
            </div>
        </form>
    </div>

    <div class="search-container">
        <div>
            <h1>Create New Admin Account:</h1>
        </div>
        <form action="http://local.muse/add_admin.php" method="post">
            <div class="search-form-container">
                <input class="input-text-field search-input-text" type="text" name="add_admin_user" placeholder="Enter a username...">
                <input class="input-text-field search-input-text" type="password" name="add_admin_password" placeholder="Enter a password...">
                <button class="button standard-button" type="submit" onclick="window.location.href = 'http://local.muse/insert.php'">Create</button>
            </div>
        </form>
    </div>

    <br />
    <br />

    <div class="footer">
        <p>MUSE Team 2021</p>
    </div>
</body>
</html>
