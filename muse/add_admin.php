<!DOCTYPE html>
<html>
<head>
	<link rel="icon" href="bkgs/M_logo.png" type="image/icon type">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Muse Admin Sign In</title>
    <link rel="stylesheet" href="css/sty.css">
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>

<body class="bkg_im">
  <header>
      <div class="container_h">
      <h3 class="logo">MUSE Admin Access</h3>

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
    </header>

    <h1>Sign in as Admin to Continue</h1>

	<?php
		$servername = "localhost";
		$username = "root";
		$password = "stingrays";
		$db = "muse";
		$conn = NULL;

		try { // try mysql -p hjeon
			$conn = mysqli_connect($servername, $username, $password, $db);
			//echo "Connected successfully";
    		} catch(PDOException $e) { // print connection error message
        		//echo "Connection failed: " . $e->getMessage();
    		}
        ?>

	<?php if ($_SERVER["REQUEST_METHOD"] == "GET"): ?>
		<form method = "POST">
			<div>
				<label for = "Username">Username</label>
				  <input class="form-control" type = "text" name = "Username" placeholder="Enter admin username..." required = "required"/>
        <br>
        <label for = "Password">Password</label>
				  <input class="form-control" type = "password" name = "Password" placeholder="Enter admin password..." required = "required"/>
      </div>
      <br>
			<button class = "btn btn-outline-success" type = "submit" name = "button" value = "Log In">Log in</button>
		</form>
	<?php else: ?>
	<?php
    //session_start();

		// TODO: Logout
		// TODO: Delete account option once logged in
		// TODO: Maintaining a separate db for each individual user preferences (aka liked songs) and accessing/inserting/updating/deleting from that preferences list
		if ($_REQUEST["button"] == "Log In") {
			if (isset($_POST['Username'], $_POST['Password'])) { // check if both fields filled in
				$_SESSION['admin_loggedon'] = '0';
				$username_entered = mysqli_real_escape_string($conn, $_POST['Username']);
				$password_entered = mysqli_real_escape_string($conn, $_POST['Password']);
				//echo "$username_entered, $password_entered";
				// mysql
				$query = mysqli_query($conn, "SELECT * FROM login_data WHERE username = '$username_entered' and password = '$password_entered'");
				$count = mysqli_num_rows($query);
				// if username_entered and password_entered pair available in login_data
				session_start();
				if ($count == 1) {
					$_SESSION['admin_loggedon'] = '1';
					if ($username_entered == 'admin') {
						echo "You are now on the Admin page";
            //$_SESSION['loggedIn']=true;
            //echo $_SESSION['loggedIn'];
            //redirect_to('http://local.muse/mods.php');

            header('Location: http://local.muse/mods.php');
					} else {
						echo "Username/Password not correct";
					}
				} else { // if pair not found
					$_SESSION['admin_loggedon'] = '0';
					echo "Username/Password not correct";
					echo "<br/>";
					echo "<a href = 'http://local.muse/add_admin.php'>Back to add_admin.php</a>";
				}
			}
		}
		$conn->close();
		?>
	<?php endif ?>

</body>

</html>
