<?php

$servername = "localhost";
$username = "root";
$password = "stingrays";
$db = "muse";
$conn = NULL;

try {
    $conn = mysqli_connect($servername, $username, $password, $db);
    //echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if (isset($_GET['song_id'])) {
    $id = $_GET['song_id'];

    $query = mysqli_query($conn, "SELECT * FROM track3 where id ='$id'");

    // Return to home page if the song_id is invalid
    if (mysqli_num_rows($query) == 0) {
        header("Location: http://local.muse/");
        exit;
    } else {
        $results = array();
        while($row = mysqli_fetch_assoc($query)) {
            array_push($results, $row);
        }

        $info_query = mysqli_query($conn, "SELECT y.album, y.track_number, y.explicit, y.release_date, x.likes, x.dislikes, y.album_id from youtube_like_dl as x, track3 as y where x.id=y.id and x.id='$id'");
        $info = array();
        while($info_row = mysqli_fetch_assoc($info_query)) {
            array_push($info, $info_row);
        }

        $pie_query = mysqli_query($conn, "SELECT likes, dislikes FROM youtube_like_dl where id ='$id'");
        $pie = array();
        while($pie_row = mysqli_fetch_assoc($pie_query)) {
            array_push($pie, $pie_row);
        }

        $song_name = $results[0]['name'];
        $album_id = $info[0]['album_id'];
        $track_number = $info[0]['track_number'];
        $artists = trim($results[0]['artists'], "\"[\'\']\"");
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
    <title>MUSE Song</title>
    <link rel="stylesheet" href="css/style.css">

    <script src="app.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
</head>

<script>
    var artists = "<?php echo $artists; ?>";
</script>

<body onload="onSongPageLoad(artists)">
    <input type="hidden" id="songName" value="<?php echo $song_name; ?>">
    <input type="hidden" id="albumId" value="<?php echo $album_id; ?>">
    <input type="hidden" id="trackNum" value="<?php echo $track_number; ?>">
    <input type="hidden" id="songId" value="<?php echo $id; ?>">
    <input type="hidden" id="artistId" value="">

    <header>
        <div class="container-h">
            <h1 class="logo">MUSE Song</h1>
            <nav>
                <ul>
                    <li><a href="http://local.muse/">Home</a></li>
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
    <br />

    <div class="song-container">
        <div class="song-h">
            <h1><?php echo 'Song: \'' . $song_name . '\' by \'' . $artists . '\'' ?></h1>
            <button class="button standard-button" type="submit" onclick="window.location.href = 'http://local.muse/index.php'">Return to Search</button>
        </div>
        <div class="song-body-container">
            <div class="sb-box">
                <div class="sb-dropdown-h">
                    <label for="devices" class="form-label">DEVICES</label>
                    <button class="button standard-button" type="button" onclick="refreshDevices()">Refresh Devices</button>
                </div>
                <select id="devices" class="dropdown-field"></select>

                <div class="sb-options-h">
                    <h2>PLAY SONG</h2>
                </div>
                <div class="center-content-row">
                    <button class="button standard-button-2" type="button" onclick="play()">Play</button>
                    <button class="button standard-button-2" type="button" onclick="pause()">Pause</button>
                </div>
            </div>

            <div class="sb-box">
                <div class="sb-dropdown-h">
                    <label for="playlists" class="form-label">PLAYLISTS</label>
                    <button class="button standard-button" type="button" onclick="refreshPlaylists()">Refresh Playlists</button>
                </div>
                <select id="playlists" class="dropdown-field"></select>
                <div class="sb-dropdown-h">
                    <label for="songs" class="form-label">SONGS IN PLAYLIST</label>
                    <button class="button standard-button" type="button" onclick="displaySongs()">Display Songs</button>
                </div>
                <select id="songs" class="dropdown-field"></select>

                <div class="sb-options-h">
                    <h2><?php echo '\'' . $song_name . '\' by \'' . $artists . '\'' ?></h2>
                </div>
                <div class="center-content-row">
                    <button class="button standard-button-2" type="button" onclick="addSongToPL()">Add to Playlist</button>
                    <button class="button standard-button-2" type="button" onclick="delSongFromPL()">Delete from Playlist</button>
                </div>
            </div>

            <div class="sb-box">
                <div class="sb-dropdown-h">
                    <label for="songAttrs" class="form-label">SONG ATTRIBUTES</label>
                    <button class="button standard-button" type="button" onclick="getSongAttr()">Display Song Attributes</button>
                </div>
                <select id="songAttrs" class="dropdown-field"></select>

                <div class="sb-options-h">
                    <h2>EXPLORE</h2>
                </div>
                <div class="center-content-row">
                    <button class="button standard-button-2" type="button" onclick="showSimilarSongs()">Similar Songs</button>
                    <button class="button standard-button-2" type="button" onclick="createChart()">Bar Chart</button>
                    <button class="button standard-button-2" type="button" onclick="createPie()">Pie Graph</button>
                </div>
                <div class="center-content-col">
                    <table id="simsongs"></table>
                </div>
            </div>

            <div class="sb-box">
                <div class="sb-dropdown-h">
                    <label for="songAttrs" class="form-label">SONG INFORMATION</label>
                </div>

                <div class="center-content-col">
                    <h3>Album: <?php echo $info[0]['album']; ?></h3>
                    <h3>Track Number: <?php echo $track_number; ?></h3>
                    <h3>Explicit: <?php echo $info[0]['explicit']; ?></h3>
                    <h3>Release Date: <?php echo $info[0]['release_date']; ?></h3>
                    <h3>Likes: <?php echo $info[0]['likes']; ?></h3>
                    <h3>Dislikes: <?php echo $info[0]['dislikes']; ?></h3>
                </div>
                <div class="center-content-row">
                    <button class="button standard-button-2" type="button" onclick="followArtist()">Follow Artist</button>
                    <button class="button standard-button-2" type="button" onclick="window.location.href = 'https://open.spotify.com/track/<?php print $id; ?>'">Spotify Link</button>
                    <button class="button standard-button-2" type="button" onclick="window.location.href = 'https://www.youtube.com/results?search_query=<?php print $artists; ?>'">Search Link</button>
                </div>
            </div>
        </div>
    </div>

    <div class="visual-container">
        <canvas id="myChart"></canvas>
    </div>
    <div class="visual-container">
        <canvas id="myPie"></canvas>
    </div>

    <script>

        function createChart() {
            let myChart = document.getElementById('myChart').getContext('2d');

            // Global Options
            Chart.defaults.global.defaultFontFamily = 'Helvetica';
            Chart.defaults.global.defaultFontSize = 16;
            Chart.defaults.global.defaultFontColor = '#777';

            let massPopChart = new Chart(myChart, {
                type:'horizontalBar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
                data:{
                    labels:['Acousticness', 'Danceability','Energy','Instrumentalness', 'Liveness', 'Loudness', 'Speechiness'],
                    //labels:['Boston', 'Worcester', 'Springfield', 'Lowell', 'Cambridge', 'New Bedford'],
                    datasets:[{
                        label:'Attribute Feature Value',
                        data:[
                            document.getElementById('acousticness').value,
                            document.getElementById('danceability').value,
                            document.getElementById('energy').value,
                            document.getElementById('instrumentalness').value,
                            document.getElementById('liveness').value,
                            document.getElementById('loudness').value,
                            document.getElementById('speechiness').value
                        ],
                        //backgroundColor:'green',
                        backgroundColor:[
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                            'rgba(255, 159, 64, 0.6)',
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(255, 69, 69, 0.6)'
                        ],
                        borderWidth:1,
                        borderColor:'#777',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    }]
                },
                options:{
                    title:{
                        display:true,
                        text:'Song Attribute Profile',
                        fontSize:25
                    },
                    legend:{
                        display:false,
                        position:'right',
                        labels:{
                            fontColor:'#000'
                        }
                    },
                    layout:{
                        padding:{
                            left:50,
                            right:0,
                            bottom:0,
                            top:0
                        }
                    },
                    tooltips:{
                        enabled:true
                    }
                }
            });
        }

        function createPie() {
            let myPie = document.getElementById('myPie').getContext('2d');

            // Global Options
            Chart.defaults.global.defaultFontFamily = 'Helvetica';
            Chart.defaults.global.defaultFontSize = 16;
            Chart.defaults.global.defaultFontColor = '#777';

            let likeChart = new Chart(myPie, {
                type:'pie',
                data:{
                    labels:['Likes', 'Dislikes'],
                    datasets:[{
                        label: 'pie',
                        data:[
                            <?php echo (int)$pie[0]['likes']; ?>,
                            <?php echo (int)$pie[0]['dislikes']; ?>
                        ],
                        backgroundColor:[
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)'
                        ],
                        borderWidth:1,
                        borderColor:'#777',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    }]
                },
                options:{
                    title:{
                        display:true,
                        text:'Youtube Likes/Dislikes',
                        fontSize:25
                    },
                    legend:{
                        display:true,
                        position:'right',
                        labels:{
                            fontColor:'#000'
                        }
                    },
                    layout:{
                        padding:{
                            left:50,
                            right:0,
                            bottom:0,
                            top:0
                        }
                    },
                    tooltips:{
                        enabled:true
                    }
                }
            });
        }
    </script>

    <br />
    <br />

    <div class="footer">
        <p>MUSE Team 2021</p>
    </div>
</body>
</html>
