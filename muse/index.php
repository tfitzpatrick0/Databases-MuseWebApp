<?php

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
    <title>MUSE Home</title>
    <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">

    <script src="app.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js" type="text/javascript" charset="utf8"></script>
</head>

<body onload="onPageLoad()">
    <header>
        <div class="container-h">
            <h1 class="logo">MUSE Home</h1>
            <nav>
                <ul>
                    <li><a style="font-weight:bold" href="http://local.muse/">Home</a></li>
                    <li><a href="http://local.muse/devplan.html">DevPlan</a></li>
                    <li><a href="http://local.muse/project.html">About</a></li>
                    <li><a href="http://local.muse/login.php">Admin</a></li>
                    <li><a href="http://local.muse/oauth.php">Spotify</a></li>
                </ul>
            </nav>
        </div>
        <div class="black-line"></div>
    </header>

    <br />

    <div>
        <div class="search-container">
            <div>
                <h1>Search Songs:</h1>
            </div>
            <div class="search-form-container">
                <input id="searchText" class="input-text-field search-input-text" type="text" name="searched_song_name" placeholder="Enter the song name...">
                <button id="searchButton" class="button standard-button" type="button" onclick="getTable()">Search</button>
            </div>

            <br />

            <div class="row">
                <table id="songTable" class="display"></table>
            </div>
        </div>

        <script type="text/javascript">

            $('#searchText').keyup(function(event) {
                event.preventDefault();
                if (event.keyCode === 13) {
                    $("#searchButton").click();
                }
            });

            function msToMinutesSeconds(data){
                var minutes = Math.floor(data / 60000);
                var seconds = ((data % 60000) / 1000).toFixed(0);
                return minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
            }

            function artistTrim(data){
                if(data.match(/'([^']+)'/) !== null){
                    return data.match(/'([^']+)'/)[1]
                } else{
                    return ""
                };
            }

            function getTable(){
                console.log($('#searchText').val());
                var searchText = $('#searchText').val();
                var $response;
                $.ajax({
                    type: 'POST',
                    data: {'searched_song_name': searchText},
                    url: 'http://local.muse/requestHandler.php',
                    success:function(response){
                        var data = JSON.parse(response);
                        console.log(data);
                        if($.fn.DataTable.isDataTable("#songTable")) {
                            $('#songTable').DataTable().clear().destroy();
                        }
                        $('#songTable').DataTable({
                            data: data,
                            language: {
                                "search": "Filter: "
                            },
                            columns: [
                                {"title": "Song Name", "data": "name",
                                    "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                                        $(nTd).html("<a href='song.php?song_id=" + oData.id + "'>" + oData.name + "</a>");
                                    }
                                },
                                {"title": "Song ID", "data": "id"},
                                {"title": "Artist", "data": "artists", "render": artistTrim},
                                {"title": "Album", "data": "album"},
                                {"title": "Duration", "data": "duration_ms", "render": msToMinutesSeconds},
                                {"title": "Year", "data": "year"}
                            ]
                        });
                    }
                });
            }

        </script>
    </div>

    <br />
    <br />

    <div class="footer">
        <p>MUSE Team 2021</p>
    </div>
</body>
</html>
