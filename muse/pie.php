<?php
//$id = $_GET['song_id'];
$servername = "localhost";
$username = "hjeon";
$password = "na0103Yeh|";
$db = "hjeon";
$conn = NULL;

try {
	$conn = mysqli_connect($servername, $username, $password, $db);
    //echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

//$query = mysqli_query($conn, "SELECT likes, dislikes FROM youtube_l_dl where id ='$id'");
$pie_query = mysqli_query($conn, "SELECT likes, dislikes FROM youtube_like_dl where id ='0FE9t6xYkqWXU2ahLh6D8X'");
$pie = array();
while($pie_row = mysqli_fetch_assoc($pie_query)) {
	array_push($pie, $pie_row);
}


//$query = mysqli_query($conn, "SELECT likes, dislikes FROM youtube_l_dl where id ='$id'");
$info_query = mysqli_query($conn, 'SELECT y.album, y.track_number, y.explicit, y.release_date, x.likes, x.dislikes from youtube_like_dl as x, trackexp as y where x.id="0FE9t6xYkqWXU2ahLh6D8X" and x.id=y.id');
$info = array();
while($info_row = mysqli_fetch_assoc($info_query)) {
	array_push($info, $info_row);
}



?>

<?php print (int)$pie[0]['likes']; ?>,
<?php print (int)$pie[0]['dislikes']; ?>,
<?php echo $info[0]['likes']; ?>,
<?php print $info[0]['dislikes']; ?>,
<?php print $info[0]['album']; ?>
<?php print $info[0]['track_number']; ?>
<?php print $info[0]['explicit']; ?>
<?php print $info[0]['release_date']; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
	<script src="song.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <title>My Chart.js Chart</title>
</head>
<body>
  <h4>Song Information</h4>
    <div style="padding-left:10px">
      <h5>Album: Shape of You</h5>
      <h5>Track Number: 1</h5>
      <h5>Explicit: False</h5>
      <h5>Release Date: 1/6/17</h5>
  </div>

	<div class="row">
		<h4>Popular Tracks and Related Artists</h4>
	  <input class="btn btn-primary btn-sm mt-3" type="button" onclick="showSimilarSongs()" value="Show Similar Songs">
	  <div class="column">
	    <table id="simsongs">
	      <tr>
	        <th>No.</th>
	        <th>Song</th>
	      </tr>
	      <tr>
	        <td>1</td>
	        <td>Shivers</td>
	      </tr>
	      <tr>
	        <td>2</td>
	        <td>Bad Habits</td>
	      </tr>
	      <tr>
	        <td>3</td>
	        <td>Overpass Graffiti</td>
	      </tr>
	    </table>
	  </div>
	  <div class="column">
	    <table>
	      <tr>
	        <th>No.</th>
	        <th>Artist</th>
	      </tr>
	      <tr>
	        <td>1</td>
	        <td>Shawn Mendes
	          <button class="button button5" type="submit">Follow Artist</button>

			</td>
	      </tr>
	      <tr>
	        <td>2</td>
	        <td>James Arthur
	        <button class="button button5" type="submit">Follow Artist</button>
	        </td>
	      </tr>
	      <tr>
	        <td>3</td>
	        <td>Sam Smith
	        <button class="button button5" type="submit">Follow Artist</button>
	        </td>
	      </tr>
	    </table>
	  </div>
	</div>



  <div class="container">
    <canvas id="myPie"></canvas>
  </div>

  <script>
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
  </script>
</body>
</html>
