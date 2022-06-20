<?php

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
    <link rel="icon" href="imgs/M_logo.png" type="image/icon type">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Muse Testing</title>
    <link rel="stylesheet" href="css/sty.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
	<script src="app.js"></script>
</head>

<body onload="onPageLoad()">
    <div class="container">

        <div id="tokenSection" class="row">
            <div class="col">
                <input class="btn btn-primary btn-lg" type="button" onclick="requestAuthorization()" value="Request Authorization"></input>
            </div> 
        </div>
    </div>
</body>

</html>

<!--
<body onload="onPageLoad()">
    <div class="container">

        <div id="tokenSection" class="row">
            <div class="col">
                <p class="welcomeText">This is a javascript app that shows how to use the Spotify API to control the playback 
                    of music (playlist or albums) on any of your devices connected to your spotify account.</p>
                <p class="welcomeText">To use this app you need a Spotify client ID and client secret. You get these by 
                    creating an app in the Spotify developers dashboard here 
                    <a href="https://developer.spotify.com/dashboard/applications" target="_blank">https://developer.spotify.com/dashboard/applications</a> 
                     and add https://makeratplay.github.io/SpotifyWebAPI/ in the "Redirect URIs" settings field.
                </p>                    
                <p  class="welcomeText"> 
                    This app demostrates how the use the following APIs: 
                    <ul>
                        <li>https://accounts.spotify.com/authorize </li>
                        <li>https://accounts.spotify.com/api/token </li>
                    
                        <li>https://api.spotify.com/v1/me/playlists </li>
                        <li>https://api.spotify.com/v1/me/player/devices </li>
                        <li>https://api.spotify.com/v1/me/player/play </li>
                        <li>https://api.spotify.com/v1/me/player/pause </li>
                        <li>https://api.spotify.com/v1/me/player/next </li>
                        <li>https://api.spotify.com/v1/me/player/previous </li>
                        <li>https://api.spotify.com/v1/me/player </li>
                        <li>https://api.spotify.com/v1/playlists/{{PlaylistId}}/tracks </li>
                        <li>https://api.spotify.com/v1/me/player/currently-playing </li>
                        <li>https://api.spotify.com/v1/me/player/shuffle </li>
                    </ul>
                </p>                    
                
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="clientId" class="form-label">Client ID</label>
                    <input type="text" class="form-control" id="clientId" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="clientSecret" class="form-label">Client Secret</label>
                    <input type="text" class="form-control" id="clientSecret" placeholder="">
                </div>
                <input class="btn btn-primary btn-lg" type="button" onclick="requestAuthorization()" value="Request Authorization"><br/>
            </div>

            <div class="col">
                <p class="welcomeText" style="margin-top: 40px;"> I used this project to learn the Spotify API in order to create this project:</p>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/H2HJ-LY7-lQ" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>

        <div id="deviceSection" class="row">
            <div class="col">

                <div class="mb-3">
                    <label for="devices" class="form-label">Devices</label>
                    <select id="devices" class="form-control">
                    </select>
                    <input class="btn btn-primary btn-sm mt-3" type="button" onclick="refreshDevices()" value="Refresh Devices">
                    <input type="button" class="btn btn-dark btn-sm  mt-3" onclick="transfer()" value="Transfer">
                </div>

                <div class="mb-3">
                    <label for="playlists" class="form-label">Playlists</label>
                    <select id="playlists" class="form-control">
                    </select>
                    <input class="btn btn-primary btn-sm mt-3" type="button" onclick="refreshPlaylists()" value="Refresh Playlists">

                </div>

                <div class="mb-3">
                    <label for="tracks" class="form-label">Tracks</label>
                    <select id="tracks" class="form-control">
                    </select>
                    <input class="btn btn-primary btn-sm mt-3" type="button" onclick="fetchTracks()" value="Fetch Tracks">
                </div>

                <div class="mb-3">
                    <label for="tracks" class="form-label">Album</label>
                    <input id="album" class="form-control">
                </div>

                <div class="row">
                    <div class="col">
                        <input type="button" class="btn btn-dark" onclick="previous()" value="Prev">
                        <input type="button" class="btn btn-dark" onclick="play()" value="Play">
                        <input type="button" class="btn btn-dark" onclick="shuffle()" value="Shuffle">
                        <input type="button" class="btn btn-dark" onclick="pause()" value="Pause">
                        <input type="button" class="btn btn-dark" onclick="next()" value="Next">
                    </div>
                </div>


                <div class="row  mt-3">
                    <div class="col">
                        <h1> Currently Playing</h1>
                        <input type="button" class="btn btn-primary btn-sm mt-3" onclick="currentlyPlaying()" value="Refresh Currently Playing">
                        <div>
                            <img id="albumImage" src="">
                            <div id="trackTitle"></div>
                            <div id="trackArtist"></div>
                        </div>

                    </div>
                </div>

                <div class="row  mt-3">
                    <div class="col">
                        <div id="radioButtons"></div>
                        <input type="button" class="btn btn-dark" onclick="saveNewRadioButton()" value="Add">
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
-->