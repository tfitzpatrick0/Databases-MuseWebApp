<?php
$id = $_GET['song_id'];
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

$query = mysqli_query($conn, "SELECT * FROM track3 where id ='$id'");
$results = array();
while($row = mysqli_fetch_assoc($query)) {
	  array_push($results, $row);
}

$pie_query = mysqli_query($conn, "SELECT likes, dislikes FROM youtube_like_dl where id ='$id'");
$pie = array();
while($pie_row = mysqli_fetch_assoc($pie_query)) {
	  array_push($pie, $pie_row);
}

//$query = mysqli_query($conn, "SELECT likes, dislikes FROM youtube_l_dl where id ='$id'");
$info_query = mysqli_query($conn, "SELECT y.album, y.track_number, y.explicit, y.release_date, x.likes, x.dislikes, y.album_id from youtube_like_dl as x, trackexp as y where x.id=y.id and x.id='$id'");
$info = array();
while($info_row = mysqli_fetch_assoc($info_query)) {
	  array_push($info, $info_row);
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="bkgs/M_logo.png" type="image/icon type">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MUSE Song</title>
    <link rel="stylesheet" href="css/style.css">
	  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->

    <script src="song.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>

<!-- <style>
* {
  box-sizing: border-box;
}

.row {
  display: flex;
  margin-left:-5px;
  margin-right:-5px;
}

.column {
  flex: 50%;
  padding: 5px;
}

table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 16px;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}
.button5 {border-radius: 50%;}
</style> -->
</head>

<!-- <body onload="onPageLoad(<?php print $results[0]['artists']; ?>)"> -->
<body onload="onPageLoad()">
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
            <h1><?php echo '\'' . $results[0]['name'] . '\' by \'' . substr($results[0]['artists'], 2, strlen($results[0]['artists'])-4) . '\'' ?></h1>
            <button class="button standard-button" type="submit" onclick="window.location.href = 'http://local.muse/index.php'">Return to Search</button>
        </div>
        <div class="song-body-container">
            <div class="sb-box">A</div>
            <div class="sb-box">B</div>
            <div class="sb-box">C</div>
            <div class="sb-box">D</div>
        </div>
    </div>

    <div class="container-fluid">

    <div>
    <div class="mb-3">
        <label for="devices" class="form-label">Devices</label>
        <select id="devices" class="form-control">
        </select>
        <input class="btn btn-primary btn-sm mt-3" type="button" onclick="refreshDevices()" value="Refresh Devices">
    </div>
    <h3>Play Song:</h3>
    <div class="row">
        <div class="col">
            <input type="hidden" id="<?php echo $results[0]['name'] . ' | ' . $results[0]['artists'] ?>" value="<?php print $id; ?>">
            <input type="hidden" class="form-control" id="songName" value="<?php print $results[0]['name']; ?>">
            <input type="hidden" class="form-control" id="albumId" value="<?php echo $info[0]['album_id']; ?>">
            <input type="hidden" class="form-control" id="trackNum" value="<?php echo $info[0]['track_number']; ?>">
            <input type="button" class="btn btn-dark" onclick="play()" value="Play">
            <input type="button" class="btn btn-dark" onclick="pause()" value="Pause">
        </div>
    </div>
    <br>
    <br>
    <h4>Add/Remove Playlist Button</h4>

    <div class="mb-3">
        <label for="playlists" class="form-label">Playlists</label>
        <select id="playlists" class="form-control">
        </select>
        <input class="btn btn-primary btn-sm mt-3" type="button" onclick="refreshPlaylists()" value="Refresh Playlists">
    </div>

    <div class="mb-3">
        <label for="songs" class="form-label">Songs</label>
        <select id="songs" class="form-control">
        </select>
        <input class="btn btn-primary btn-sm mt-3" type="button" onclick="displaySongs()" value="Display Songs">
    </div>

    <div class="mb-3">
        <label for="songId" class="form-label">Song Name: <?php echo $results[0]['name'] . ' | ' . $results[0]['artists'] ?></label>
        <input type="hidden" class="form-control" id="songId" value="<?php print $id; ?>">
        <input type="hidden" class="form-control" id="artistId" value="">
        <div class="column"></div>
        <input class="btn btn-primary btn-sm mt-3" type="button" onclick="addSongToPL()" value="Add To Playlist">
        <input class="btn btn-primary btn-sm mt-3" type="button" onclick="delSongFromPL()" value="Delete From Playlist">
        <input class="btn btn-primary btn-sm mt-3" type="button" onclick="followArtist()" value="Follow Artist">
    </div>

<!--  <a href="https://open.spotify.com/track/">Spotify Link</a> -->
<a class="btn btn-outline-success" href="https://open.spotify.com/track/<?php print $id; ?>">Spotify Link</a>
<!-- <a class="btn btn-outline-success" href="https://www.youtube.com/channel/UC0C-w0YjGpqDXGB8IHb662A">YouTube Artist Link</a> -->
<a class="btn btn-outline-success" href="https://www.youtube.com/results?search_query=<?php print $results[0]['artists']; ?>">Search Link</a>

<h4>Song Information</h4>
  <div style="padding-left:10px">
    <h5>Album: <?php echo $info[0]['album']; ?></h5>
    <h5>Track Number: <?php echo $info[0]['track_number']; ?></h5>
    <h5>Explicit: <?php echo $info[0]['explicit']; ?></h5>
    <h5>Release Date: <?php echo $info[0]['release_date']; ?></h5>
		<h5>Likes: <?php echo $info[0]['likes']; ?></h5>
		<h5>Dislikes: <?php echo $info[0]['dislikes']; ?></h5>
</div>

    <div class="mb-3">
        <label for="songAttrs" class="form-label">Song Attributes</label>
        <select id="songAttrs" class="form-control">
        </select>
        <input class="btn btn-primary btn-sm mt-3" type="button" onclick="getSongAttr()" value="Get Song Attributes">
    </div>

<h4>Chart of song qualities from api</h4>
    <div class="mb-3">
        <input class="btn btn-primary btn-sm mt-3" type="button" onclick="createChart()" value="Create Bar Chart">
        <input class="btn btn-primary btn-sm mt-3" type="button" onclick="createPie()" value="Create Pie Graph">
    </div>

<div class="container">
    <canvas id="myChart"></canvas>
</div>

<div class="container">
    <canvas id="myPie"></canvas>
</div>

<script>
  function createChart() {
      let myChart = document.getElementById('myChart').getContext('2d');

      // Global Options
      Chart.defaults.global.defaultFontFamily = 'Helvetica';
      Chart.defaults.global.defaultFontSize = 16;
      Chart.defaults.global.defaultFontColor = '#777';

      let test = document.getElementById('songAttrs').options[0];
      //let test = 5;
      console.log(test);

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
        type:'pie', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
        data:{
          labels:['Likes', 'Dislikes'],
          datasets:[{
            label: 'pie',
            data:[
							<?php echo (int)$pie[0]['likes']; ?>,
	            <?php echo (int)$pie[0]['dislikes']; ?>
            ],
            //backgroundColor:'green',
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
            text:'Youtube Profile Likes/Dislikes',
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

<div class="row">
	<h4>Popular Tracks and Related Artists</h4>
  <input class="btn btn-primary btn-sm mt-3" type="button" onclick="showSimilarSongs()" value="Show Similar Songs">
  <div class="column">
    <table id="simsongs">
    </table>
  </div>
</div>

<br>

</div>
</div>
</body>
</html>
