<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="bkgs/M_logo.png" type="image/icon type">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <title>Spotify Login</title>
    <link rel="stylesheet" href="css/sty.css">
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <style>
      body {
      text-align:center;
      }
      .btn{
        display:inline-block;
      }
    </style>
    <script src="app.js"></script>
</head>

<body onload="onPageLoad()" class="bkg_im">
  <header>
      <div class="container_h">
      <h3 class="logo">Spotify Login</h3>

        <nav>
          <ul>
            <li><a href="http://local.muse/">Home</a></li>
            <li><a href="http://local.muse/devplan.html">DevPlan</a></li>
            <li><a href="http://local.muse/project.html">About</a></li>
            <li><a href="http://local.muse/login.php">Admin</a></li>
            <li><a style="font-weight:bold" href="http://local.muse/oauth.php">Login</a></li>
          </ul>
        </nav>
      </div>
    </header>


    <h1>Continue with Spotify for Advanced Features</h1>
    <br>
    <br>
    <div>
		<img src="bkgs/Spotify_Icon_RGB_Black copy.png" style="width: 185px;" alt="logo">
<!--
      <div class="mb-3">
        <label for="clientId" class="form-label">Client ID</label>
        <input type="text" class="form-control" id="clientId" placeholder="">
      </div>

      <div class="mb-3">
        <label for="clientSecret" class="form-label">Client Secret</label>
        <input type="text" class="form-control" id="clientSecret" placeholder="">
      </div>
-->
      <button class = "btn btn-outline-success" type = "submit" name = "button" onclick="requestAuthorization()" value = "Log in with Spotify">Log in with Spotify</button>
    </div>


</body>

</html>
